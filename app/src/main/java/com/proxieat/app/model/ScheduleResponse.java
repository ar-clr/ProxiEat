package com.proxieat.app.model;

import com.google.gson.annotations.SerializedName;
import java.util.List;

/**
 * Wraps a list of ScheduleItem objects returned by api/schedule.json.
 */
public class ScheduleResponse {

    @SerializedName("schedules")
    private List<ScheduleItem> schedules;

    public List<ScheduleItem> getSchedules() { return schedules; }
    public void setSchedules(List<ScheduleItem> schedules) { this.schedules = schedules; }
}
