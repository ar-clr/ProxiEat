package com.proxieat.app;

import android.os.Bundle;

import androidx.appcompat.app.AppCompatActivity;
import androidx.navigation.NavController;
import androidx.navigation.fragment.NavHostFragment;
import androidx.navigation.ui.AppBarConfiguration;
import androidx.navigation.ui.NavigationUI;

import com.google.android.material.bottomnavigation.BottomNavigationView;
import com.proxieat.app.databinding.ActivityMainBinding;

public class MainActivity extends AppCompatActivity {

    private ActivityMainBinding binding;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);

        binding = ActivityMainBinding.inflate(getLayoutInflater());
        setContentView(binding.getRoot());

        // Set up Navigation Component with BottomNavigationView
        NavHostFragment navHostFragment = (NavHostFragment) getSupportFragmentManager()
                .findFragmentById(R.id.nav_host_fragment);

        if (navHostFragment != null) {
            NavController navController = navHostFragment.getNavController();

            // Top-level destinations (no back arrow shown for these)
            AppBarConfiguration appBarConfiguration = new AppBarConfiguration.Builder(
                    R.id.navigation_dashboard,
                    R.id.navigation_feed,
                    R.id.navigation_schedule,
                    R.id.navigation_camera
            ).build();

            // Connect ActionBar with NavController
            NavigationUI.setupActionBarWithNavController(
                    this, navController, appBarConfiguration);

            // Connect BottomNavigation with NavController
            NavigationUI.setupWithNavController(
                    binding.bottomNavigation, navController);
        }
    }
}
