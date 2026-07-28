package com.proxieat.app.model;

import com.google.gson.annotations.SerializedName;

/**
 * Maps to api/dispense.php response.
 * Example JSON: {"status": "ok", "message": "Dispensed Medium portion"}
 */
public class DispenseResponse {

    @SerializedName("status")
    private String status;

    @SerializedName("message")
    private String message;

    public String getStatus()  { return status;  }
    public String getMessage() { return message; }

    public boolean isSuccess() {
        return "ok".equalsIgnoreCase(status) || "success".equalsIgnoreCase(status);
    }
}
