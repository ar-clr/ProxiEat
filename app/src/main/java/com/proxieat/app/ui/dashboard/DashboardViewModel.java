package com.proxieat.app.ui.dashboard;

import androidx.lifecycle.LiveData;
import androidx.lifecycle.MutableLiveData;
import androidx.lifecycle.ViewModel;

import com.proxieat.app.api.RetrofitClient;
import com.proxieat.app.model.TankData;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class DashboardViewModel extends ViewModel {

    private final MutableLiveData<TankData> tankData    = new MutableLiveData<>();
    private final MutableLiveData<String>   errorMessage = new MutableLiveData<>();
    private final MutableLiveData<Boolean>  isLoading   = new MutableLiveData<>(false);

    // ---- Exposed LiveData ----

    public LiveData<TankData> getTankData()    { return tankData;     }
    public LiveData<String>   getErrorMessage(){ return errorMessage; }
    public LiveData<Boolean>  getIsLoading()   { return isLoading;    }

    /**
     * Fetches the latest sensor data from the PHP backend.
     * Called both on initial load and by the polling timer.
     */
    public void fetchTankData() {
        isLoading.setValue(true);

        RetrofitClient.getInstance().getApiService()
                .getTankData()
                .enqueue(new Callback<TankData>() {
                    @Override
                    public void onResponse(Call<TankData> call, Response<TankData> response) {
                        isLoading.postValue(false);
                        if (response.isSuccessful() && response.body() != null) {
                            tankData.postValue(response.body());
                        } else {
                            errorMessage.postValue("Server error: " + response.code());
                        }
                    }

                    @Override
                    public void onFailure(Call<TankData> call, Throwable t) {
                        isLoading.postValue(false);
                        errorMessage.postValue("Connection failed: " + t.getMessage());
                    }
                });
    }
}
