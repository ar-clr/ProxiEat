package com.proxieat.app.ui.dashboard;

import android.os.Bundle;
import android.os.Handler;
import android.os.Looper;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.fragment.app.Fragment;
import androidx.lifecycle.ViewModelProvider;

import com.proxieat.app.api.ApiConfig;
import com.proxieat.app.databinding.FragmentDashboardBinding;
import com.proxieat.app.model.TankData;

public class DashboardFragment extends Fragment {

    private FragmentDashboardBinding binding;
    private DashboardViewModel       viewModel;

    // Periodic polling handler
    private final Handler  pollHandler  = new Handler(Looper.getMainLooper());
    private final Runnable pollRunnable = new Runnable() {
        @Override
        public void run() {
            viewModel.fetchTankData();
            pollHandler.postDelayed(this, ApiConfig.POLL_INTERVAL_MS);
        }
    };

    // ----------------------------------------------------------------

    @Override
    public View onCreateView(@NonNull LayoutInflater inflater,
                             ViewGroup container, Bundle savedInstanceState) {
        binding = FragmentDashboardBinding.inflate(inflater, container, false);
        return binding.getRoot();
    }

    @Override
    public void onViewCreated(@NonNull View view, @Nullable Bundle savedInstanceState) {
        super.onViewCreated(view, savedInstanceState);

        viewModel = new ViewModelProvider(this).get(DashboardViewModel.class);

        observeViewModel();

        // Swipe-to-refresh
        binding.swipeRefresh.setOnRefreshListener(() -> viewModel.fetchTankData());
    }

    // ----------------------------------------------------------------
    // OBSERVERS
    // ----------------------------------------------------------------

    private void observeViewModel() {

        viewModel.getTankData().observe(getViewLifecycleOwner(), this::updateUI);

        viewModel.getIsLoading().observe(getViewLifecycleOwner(),
                loading -> binding.swipeRefresh.setRefreshing(loading));

        viewModel.getErrorMessage().observe(getViewLifecycleOwner(), error -> {
            if (error != null && !error.isEmpty()) {
                binding.tvConnectionStatus.setText("⚠ " + error);
                binding.tvConnectionStatus.setVisibility(View.VISIBLE);
            }
        });
    }

    // ----------------------------------------------------------------
    // UI UPDATE
    // ----------------------------------------------------------------

    private void updateUI(TankData data) {

        binding.tvConnectionStatus.setVisibility(View.GONE);

        // ---- Food card ----
        int food = data.getFood();
        binding.tvFoodPercent.setText(food + "%");
        binding.progressFood.setProgress(food);
        binding.tvFoodStatus.setText(getFoodStatus(food));

        // ---- Water card ----
        int water = data.getWater();
        binding.tvWaterPercent.setText(water + "%");
        binding.progressWater.setProgress(water);
        binding.tvWaterStatus.setText(getWaterStatus(water));

        // ---- Bowl weight card ----
        int bowl = data.getBowl();
        binding.tvBowlWeight.setText(bowl + "g");
        binding.tvBowlStatus.setText(bowl > 0 ? "Food in bowl" : "Bowl is empty");
    }

    // ---- Status helpers ----

    private String getFoodStatus(int pct) {
        if (pct >= 60) return "✓ Sufficient";
        if (pct >= 30) return "⚠ Getting low";
        return "⚠ Refill soon";
    }

    private String getWaterStatus(int pct) {
        if (pct >= 60) return "✓ Good level";
        if (pct >= 30) return "⚠ Getting low";
        return "⚠ Low — refill";
    }

    // ----------------------------------------------------------------
    // LIFECYCLE — start / stop polling
    // ----------------------------------------------------------------

    @Override
    public void onResume() {
        super.onResume();
        pollHandler.post(pollRunnable);
    }

    @Override
    public void onPause() {
        super.onPause();
        pollHandler.removeCallbacks(pollRunnable);
    }

    @Override
    public void onDestroyView() {
        super.onDestroyView();
        binding = null;
    }
}
