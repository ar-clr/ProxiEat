package com.proxieat.app.model;

import com.google.gson.annotations.SerializedName;

/**
 * Maps to api/tank.json response.
 * Example JSON: {"food": 72, "water": 61, "bowl": 20}
 */
public class TankData {

    @SerializedName("food")
    private int food;

    @SerializedName("water")
    private int water;

    @SerializedName("bowl")
    private int bowl;

    // ---- Getters ----

    public int getFood()  { return food;  }
    public int getWater() { return water; }
    public int getBowl()  { return bowl;  }

    // ---- Setters (for testing/mocking) ----

    public void setFood(int food)   { this.food  = food;  }
    public void setWater(int water) { this.water = water; }
    public void setBowl(int bowl)   { this.bowl  = bowl;  }
}
