package com.proxieat.app.ui.schedule;

import androidx.lifecycle.LiveData;
import androidx.lifecycle.MutableLiveData;
import androidx.lifecycle.ViewModel;

import com.proxieat.app.api.RetrofitClient;
import com.proxieat.app.model.ScheduleItem;
import com.proxieat.app.model.ScheduleResponse;

import java.util.ArrayList;
import java.util.List;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class ScheduleViewModel extends ViewModel {

    private final MutableLiveData<List<ScheduleItem>> schedules    = new MutableLiveData<>(new ArrayList<>());
    private final MutableLiveData<String>             statusMessage = new MutableLiveData<>();
    private final MutableLiveData<Boolean>            isLoading    = new MutableLiveData<>(false);

    // ---- Exposed LiveData ----

    public LiveData<List<ScheduleItem>> getSchedules()     { return schedules;     }
    public LiveData<String>             getStatusMessage() { return statusMessage; }
    public LiveData<Boolean>            getIsLoading()     { return isLoading;     }

    /**
     * Fetches the current schedule list from the backend.
     */
    public void fetchSchedules() {
        isLoading.setValue(true);

        RetrofitClient.getInstance().getApiService()
                .getSchedules()
                .enqueue(new Callback<ScheduleResponse>() {
                    @Override
                    public void onResponse(Call<ScheduleResponse> call,
                                           Response<ScheduleResponse> response) {
                        isLoading.postValue(false);

                        if (response.isSuccessful()
                                && response.body() != null
                                && response.body().getSchedules() != null) {
                            schedules.postValue(response.body().getSchedules());
                        } else {
                            // Fall back to a default schedule if the endpoint is missing
                            schedules.postValue(getDefaultSchedules());
                        }
                    }

                    @Override
                    public void onFailure(Call<ScheduleResponse> call, Throwable t) {
                        isLoading.postValue(false);
                        schedules.postValue(getDefaultSchedules());
                        statusMessage.postValue("Offline mode — showing cached schedule.");
                    }
                });
    }

    /**
     * Adds a new schedule entry to the local list and posts a success message.
     * Extend this to also POST to the backend as needed.
     */
    public void addSchedule(String time, String portion, String repeat) {
        List<ScheduleItem> current = schedules.getValue();
        if (current == null) current = new ArrayList<>();

        current.add(new ScheduleItem(time, portion, repeat));
        schedules.setValue(current);
        statusMessage.setValue("✅ Schedule saved — " + time + " (" + getPortionLabel(portion) + ")");
    }

    /**
     * Removes the schedule item at the given index.
     */
    public void removeSchedule(int index) {
        List<ScheduleItem> current = schedules.getValue();
        if (current != null && index >= 0 && index < current.size()) {
            current.remove(index);
            schedules.setValue(current);
            statusMessage.setValue("🗑 Schedule removed.");
        }
    }

    // ---- Helpers ----

    private String getPortionLabel(String code) {
        switch (code) {
            case "S": return "Small";
            case "L": return "Large";
            default:  return "Medium";
        }
    }

    private List<ScheduleItem> getDefaultSchedules() {
        List<ScheduleItem> list = new ArrayList<>();
        list.add(new ScheduleItem("8:00 AM",  "M", "Daily"));
        list.add(new ScheduleItem("12:30 PM", "M", "Daily"));
        list.add(new ScheduleItem("2:00 PM",  "M", "Daily"));
        return list;
    }
}
