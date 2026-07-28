package com.proxieat.app.ui.schedule;

import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.fragment.app.Fragment;
import androidx.lifecycle.ViewModelProvider;
import androidx.recyclerview.widget.LinearLayoutManager;

import com.google.android.material.timepicker.MaterialTimePicker;
import com.google.android.material.timepicker.TimeFormat;
import com.proxieat.app.R;
import com.proxieat.app.databinding.FragmentScheduleBinding;

import java.util.Locale;

public class ScheduleFragment extends Fragment {

    private FragmentScheduleBinding binding;
    private ScheduleViewModel       viewModel;
    private ScheduleAdapter         adapter;

    // Selected time state
    private int    selectedHour   = 8;
    private int    selectedMinute = 0;

    // ----------------------------------------------------------------

    @Override
    public View onCreateView(@NonNull LayoutInflater inflater,
                             ViewGroup container, Bundle savedInstanceState) {
        binding = FragmentScheduleBinding.inflate(inflater, container, false);
        return binding.getRoot();
    }

    @Override
    public void onViewCreated(@NonNull View view, @Nullable Bundle savedInstanceState) {
        super.onViewCreated(view, savedInstanceState);

        viewModel = new ViewModelProvider(this).get(ScheduleViewModel.class);

        setupPortionDropdown();
        setupRecyclerView();
        setupTimePicker();
        setupSaveButton();
        observeViewModel();

        viewModel.fetchSchedules();
    }

    // ----------------------------------------------------------------
    // SETUP
    // ----------------------------------------------------------------

    private void setupPortionDropdown() {
        String[] portions = {"Small", "Medium", "Large"};
        ArrayAdapter<String> adapter = new ArrayAdapter<>(
                requireContext(),
                android.R.layout.simple_dropdown_item_1line,
                portions
        );
        binding.spinnerPortion.setAdapter(adapter);
        binding.spinnerPortion.setSelection(1); // Default: Medium
    }

    private void setupRecyclerView() {
        adapter = new ScheduleAdapter(item -> {
            // Delete callback
            int index = viewModel.getSchedules().getValue() != null
                    ? viewModel.getSchedules().getValue().indexOf(item) : -1;
            if (index >= 0) viewModel.removeSchedule(index);
        });

        binding.recyclerSchedules.setLayoutManager(
                new LinearLayoutManager(requireContext()));
        binding.recyclerSchedules.setAdapter(adapter);
    }

    private void setupTimePicker() {
        // Show the selected time in the button label
        updateTimeLabel();

        binding.btnPickTime.setOnClickListener(v -> {
            MaterialTimePicker picker = new MaterialTimePicker.Builder()
                    .setTimeFormat(TimeFormat.CLOCK_12H)
                    .setHour(selectedHour)
                    .setMinute(selectedMinute)
                    .setTitleText("Select feeding time")
                    .build();

            picker.addOnPositiveButtonClickListener(dialog -> {
                selectedHour   = picker.getHour();
                selectedMinute = picker.getMinute();
                updateTimeLabel();
            });

            picker.show(getChildFragmentManager(), "TIME_PICKER");
        });
    }

    private void updateTimeLabel() {
        int    displayHour = selectedHour % 12;
        if (displayHour == 0) displayHour = 12;
        String amPm        = selectedHour >= 12 ? "PM" : "AM";
        String label       = String.format(Locale.getDefault(),
                "%d:%02d %s", displayHour, selectedMinute, amPm);
        binding.btnPickTime.setText("🕐  " + label);
    }

    private void setupSaveButton() {
        binding.btnSaveSchedule.setOnClickListener(v -> {

            // Build time string
            int    displayHour = selectedHour % 12;
            if (displayHour == 0) displayHour = 12;
            String amPm        = selectedHour >= 12 ? "PM" : "AM";
            String timeStr     = String.format(Locale.getDefault(),
                    "%d:%02d %s", displayHour, selectedMinute, amPm);

            // Map dropdown selection to portion code
            int    selectedPos = binding.spinnerPortion.getSelectedItemPosition();
            String portionCode = selectedPos == 0 ? "S" : (selectedPos == 2 ? "L" : "M");
            String repeatStr   = "Daily";

            viewModel.addSchedule(timeStr, portionCode, repeatStr);
        });
    }

    // ----------------------------------------------------------------
    // OBSERVERS
    // ----------------------------------------------------------------

    private void observeViewModel() {

        viewModel.getSchedules().observe(getViewLifecycleOwner(), items -> {
            adapter.submitList(items != null ? new java.util.ArrayList<>(items) : new java.util.ArrayList<>());
            binding.tvEmptySchedule.setVisibility(
                    (items == null || items.isEmpty()) ? View.VISIBLE : View.GONE);
        });

        viewModel.getIsLoading().observe(getViewLifecycleOwner(),
                loading -> binding.progressSchedule.setVisibility(
                        loading ? View.VISIBLE : View.GONE));

        viewModel.getStatusMessage().observe(getViewLifecycleOwner(), msg -> {
            if (msg != null && !msg.isEmpty()) {
                binding.tvScheduleStatus.setText(msg);
                binding.tvScheduleStatus.setVisibility(View.VISIBLE);
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
