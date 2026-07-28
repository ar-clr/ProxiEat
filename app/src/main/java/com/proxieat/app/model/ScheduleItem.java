package com.proxieat.app.model;

import com.google.gson.annotations.SerializedName;

/**
 * Represents a single scheduled feeding entry.
 * Example JSON: {"time": "08:00", "portion": "M", "repeat": "Daily"}
 */
public class ScheduleItem {

    @SerializedName("time")
    private String time;

    @SerializedName("portion")
    private String portion;   // "S", "M", or "L"

    @SerializedName("repeat")
    private String repeat;    // "Daily", "Mon-Fri", etc.

    // ---- Constructor ----

    public ScheduleItem(String time, String portion, String repeat) {
        this.time    = time;
        this.portion = portion;
        this.repeat  = repeat;
    }

    // ---- Getters / Setters ----

    public String getTime()    { return time;    }
    public String getPortion() { return portion; }
    public String getRepeat()  { return repeat;  }

    public void setTime(String time)       { this.time    = time;    }
    public void setPortion(String portion) { this.portion = portion; }
    public void setRepeat(String repeat)   { this.repeat  = repeat;  }

    /** Returns the human-readable label for this item's portion size. */
    public String getPortionLabel() {
        switch (portion != null ? portion : "M") {
            case "S": return "Small";
            case "L": return "Large";
            default:  return "Medium";
        }
    }
}
