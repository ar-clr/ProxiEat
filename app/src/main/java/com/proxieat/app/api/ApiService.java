package com.proxieat.app.api;

import com.proxieat.app.model.DispenseResponse;
import com.proxieat.app.model.ScheduleResponse;
import com.proxieat.app.model.TankData;

import retrofit2.Call;
import retrofit2.http.GET;
import retrofit2.http.Query;

public interface ApiService {

    /**
     * GET api/tank.json
     * Returns live sensor data: food %, water %, bowl weight (g).
     */
    @GET("api/tank.json")
    Call<TankData> getTankData();

    /**
     * GET api/dispense.php?portion=S|M|L
     * Triggers servo motor dispense for the given portion size.
     */
    @GET("api/dispense.php")
    Call<DispenseResponse> dispense(@Query("portion") String portion);

    /**
     * GET api/schedule.json
     * Returns the current list of scheduled feeding times.
     */
    @GET("api/schedule.json")
    Call<ScheduleResponse> getSchedules();
}
