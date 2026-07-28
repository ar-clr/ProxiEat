package com.proxieat.app.api;

public class ApiConfig {

    // ---------------------------------------------------------------
    // Base URL — update to your actual PHP server address
    // Example: "http://192.168.254.191/furbytes-sample/"
    // ---------------------------------------------------------------
    public static final String BASE_URL = "http://192.168.254.191/furbytes-sample/";

    // ---------------------------------------------------------------
    // ESP32-CAM stream / snapshot URLs
    // ---------------------------------------------------------------
    public static final String CAM_STREAM_URL   = "http://192.168.254.191:81/stream";
    public static final String CAM_SNAPSHOT_URL = "http://192.168.254.191/capture";

    // ---------------------------------------------------------------
    // API endpoint paths (relative to BASE_URL)
    // ---------------------------------------------------------------
    public static final String ENDPOINT_TANK     = "api/tank.json";
    //public static final String ENDPOINT_DISPENSE = "api/dispense.php";
    //public static final String ENDPOINT_SCHEDULE = "api/schedule.json";
    public static final String ENDPOINT_COMMAND  = "api/command.json";

    // ---------------------------------------------------------------
    // Poll interval for live sensor data (milliseconds)
    // ---------------------------------------------------------------
    public static final long POLL_INTERVAL_MS = 2000L;
}
