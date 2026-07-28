package com.proxieat.app.ui.feed;

import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.fragment.app.Fragment;
import androidx.lifecycle.ViewModelProvider;

import com.google.android.material.snackbar.Snackbar;
import com.proxieat.app.databinding.FragmentFeedBinding;

public class FeedFragment extends Fragment {

    private FragmentFeedBinding binding;
    private FeedViewModel       viewModel;

    // ----------------------------------------------------------------

    @Override
    public View onCreateView(@NonNull LayoutInflater inflater,
                             ViewGroup container, Bundle savedInstanceState) {
        binding = FragmentFeedBinding.inflate(inflater, container, false);
        return binding.getRoot();
    }

    @Override
    public void onViewCreated(@NonNull View view, @Nullable Bundle savedInstanceState) {
        super.onViewCreated(view, savedInstanceState);

        viewModel = new ViewModelProvider(this).get(FeedViewModel.class);

        setupButtons();
        observeViewModel();
    }

    // ----------------------------------------------------------------
    // BUTTON SETUP
    // ----------------------------------------------------------------

    private void setupButtons() {

        // Small portion button
        binding.btnSmall.setOnClickListener(v -> {
            highlightSelected(binding.btnSmall, binding.btnMedium, binding.btnLarge);
            showConfirmAndDispense("S", "Small");
        });

        // Medium portion button
        binding.btnMedium.setOnClickListener(v -> {
            highlightSelected(binding.btnMedium, binding.btnSmall, binding.btnLarge);
            showConfirmAndDispense("M", "Medium");
        });

        // Large portion button
        binding.btnLarge.setOnClickListener(v -> {
            highlightSelected(binding.btnLarge, binding.btnSmall, binding.btnMedium);
            showConfirmAndDispense("L", "Large");
        });
    }

    /**
     * Visually marks one button as selected and the others as unselected.
     */
    private void highlightSelected(View selected, View other1, View other2) {
        selected.setAlpha(1.0f);
        other1.setAlpha(0.55f);
        other2.setAlpha(0.55f);
    }

    /**
     * Shows a confirmation snackbar, then sends the dispense API call on confirm.
     */
    private void showConfirmAndDispense(String portionCode, String portionLabel) {
        Snackbar.make(
                requireView(),
                "Dispense " + portionLabel + " portion?",
                Snackbar.LENGTH_LONG
        ).setAction("Confirm", v -> viewModel.dispense(portionCode))
         .show();
    }

    // ----------------------------------------------------------------
    // OBSERVERS
    // ----------------------------------------------------------------

    private void observeViewModel() {

        viewModel.getIsLoading().observe(getViewLifecycleOwner(), loading -> {
            binding.progressDispense.setVisibility(loading ? View.VISIBLE : View.GONE);
            binding.btnSmall.setEnabled(!loading);
            binding.btnMedium.setEnabled(!loading);
            binding.btnLarge.setEnabled(!loading);
        });

        viewModel.getDispenseResult().observe(getViewLifecycleOwner(), result -> {
            if (result != null && !result.isEmpty()) {
                binding.tvDispenseResult.setText(result);
                binding.tvDispenseResult.setVisibility(View.VISIBLE);

                // Reset button alpha after a successful/failed dispense
                binding.btnSmall.setAlpha(1.0f);
                binding.btnMedium.setAlpha(1.0f);
                binding.btnLarge.setAlpha(1.0f);
            }
        });
    }

    // ----------------------------------------------------------------

    @Override
    public void onDestroyView() {
        super.onDestroyView();
        binding = null;
    }
}
