package com.proxieat.app.ui.feed;

import androidx.lifecycle.LiveData;
import androidx.lifecycle.MutableLiveData;
import androidx.lifecycle.ViewModel;

import com.proxieat.app.api.RetrofitClient;
import com.proxieat.app.model.DispenseResponse;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class FeedViewModel extends ViewModel {

    private final MutableLiveData<String>  dispenseResult = new MutableLiveData<>();
    private final MutableLiveData<Boolean> isLoading      = new MutableLiveData<>(false);
    private final MutableLiveData<Boolean> isSuccess      = new MutableLiveData<>();

    // ---- Exposed LiveData ----

    public LiveData<String>  getDispenseResult() { return dispenseResult; }
    public LiveData<Boolean> getIsLoading()      { return isLoading;      }
    public LiveData<Boolean> getIsSuccess()      { return isSuccess;      }

    /**
     * Sends a dispense command for the given portion size (S, M, or L).
     */
    public void dispense(String portionCode) {
        isLoading.setValue(true);

        RetrofitClient.getInstance().getApiService()
                .dispense(portionCode)
                .enqueue(new Callback<DispenseResponse>() {
                    @Override
                    public void onResponse(Call<DispenseResponse> call,
                                           Response<DispenseResponse> response) {
                        isLoading.postValue(false);

                        if (response.isSuccessful() && response.body() != null) {
                            DispenseResponse body = response.body();
                            isSuccess.postValue(body.isSuccess());
                            dispenseResult.postValue(
                                    body.isSuccess()
                                            ? "✅ " + getPortionLabel(portionCode) + " portion dispensed!"
                                            : "⚠ Server response: " + body.getMessage()
                            );
                        } else {
                            isSuccess.postValue(false);
                            dispenseResult.postValue("❌ Server error: " + response.code());
                        }
                    }

                    @Override
                    public void onFailure(Call<DispenseResponse> call, Throwable t) {
                        isLoading.postValue(false);
                        isSuccess.postValue(false);
                        dispenseResult.postValue("❌ Connection failed: " + t.getMessage());
                    }
                });
    }

    private String getPortionLabel(String code) {
        switch (code) {
            case "S": return "Small";
            case "L": return "Large";
            default:  return "Medium";
        }
    }
}
