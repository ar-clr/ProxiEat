package com.proxieat.app.ui.camera;

import android.os.Bundle;
import android.os.Handler;
import android.os.Looper;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.fragment.app.Fragment;

import com.bumptech.glide.Glide;
import com.bumptech.glide.load.engine.DiskCacheStrategy;
import com.bumptech.glide.request.RequestOptions;
import com.proxieat.app.api.ApiConfig;
import com.proxieat.app.databinding.FragmentCameraBinding;

public class CameraFragment extends Fragment {

    private FragmentCameraBinding binding;

    // Refresh the MJPEG snapshot every 2 seconds as a fallback
    private final Handler  refreshHandler  = new Handler(Looper.getMainLooper());
    private final Runnable refreshRunnable = new Runnable() {
        @Override
        public void run() {
            loadSnapshot();
            refreshHandler.postDelayed(this, 2000);
        }
    };

    // ----------------------------------------------------------------

    @Override
    public View onCreateView(@NonNull LayoutInflater inflater,
                             ViewGroup container, Bundle savedInstanceState) {
        binding = FragmentCameraBinding.inflate(inflater, container, false);
        return binding.getRoot();
    }

    @Override
    public void onViewCreated(@NonNull View view, @Nullable Bundle savedInstanceState) {
        super.onViewCreated(view, savedInstanceState);

        binding.tvStreamUrl.setText(ApiConfig.CAM_STREAM_URL);

        // Manual refresh button
        binding.btnRefreshCamera.setOnClickListener(v -> loadSnapshot());

        // Load first snapshot immediately
        loadSnapshot();
    }

    // ----------------------------------------------------------------
    // LOAD ESP32-CAM SNAPSHOT VIA GLIDE
    // ----------------------------------------------------------------

    private void loadSnapshot() {
        if (binding == null || !isAdded()) return;

        // Append timestamp to bust Glide's cache and get a fresh frame
        String url = ApiConfig.CAM_SNAPSHOT_URL + "?t=" + System.currentTimeMillis();

        RequestOptions options = new RequestOptions()
                .diskCacheStrategy(DiskCacheStrategy.NONE)   // no disk cache
                .skipMemoryCache(true)                        // no memory cache
                .timeout(5000);                               // 5-second timeout

        Glide.with(requireContext())
                .load(url)
                .apply(options)
                .into(binding.ivCameraFeed);
    }

    // ----------------------------------------------------------------
    // LIFECYCLE
    // ----------------------------------------------------------------

    @Override
    public void onResume() {
        super.onResume();
        refreshHandler.post(refreshRunnable);
    }

    @Override
    public void onPause() {
        super.onPause();
        refreshHandler.removeCallbacks(refreshRunnable);
    }

    @Override
    public void onDestroyView() {
        super.onDestroyView();
        binding = null;
    }
}
