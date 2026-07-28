package com.proxieat.app.ui.schedule;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageButton;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.DiffUtil;
import androidx.recyclerview.widget.ListAdapter;
import androidx.recyclerview.widget.RecyclerView;

import com.proxieat.app.R;
import com.proxieat.app.model.ScheduleItem;

public class ScheduleAdapter extends ListAdapter<ScheduleItem, ScheduleAdapter.ViewHolder> {

    public interface OnDeleteListener {
        void onDelete(ScheduleItem item);
    }

    private final OnDeleteListener deleteListener;

    public ScheduleAdapter(OnDeleteListener deleteListener) {
        super(DIFF_CALLBACK);
        this.deleteListener = deleteListener;
    }

    // ----------------------------------------------------------------
    // DIFF UTIL
    // ----------------------------------------------------------------

    private static final DiffUtil.ItemCallback<ScheduleItem> DIFF_CALLBACK =
            new DiffUtil.ItemCallback<ScheduleItem>() {
                @Override
                public boolean areItemsTheSame(@NonNull ScheduleItem a, @NonNull ScheduleItem b) {
                    return a.getTime().equals(b.getTime()) && a.getPortion().equals(b.getPortion());
                }

                @Override
                public boolean areContentsTheSame(@NonNull ScheduleItem a, @NonNull ScheduleItem b) {
                    return a.getTime().equals(b.getTime())
                            && a.getPortion().equals(b.getPortion())
                            && a.getRepeat().equals(b.getRepeat());
                }
            };

    // ----------------------------------------------------------------
    // VIEWHOLDER
    // ----------------------------------------------------------------

    @NonNull
    @Override
    public ViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        View v = LayoutInflater.from(parent.getContext())
                .inflate(R.layout.item_schedule, parent, false);
        return new ViewHolder(v);
    }

    @Override
    public void onBindViewHolder(@NonNull ViewHolder holder, int position) {
        ScheduleItem item = getItem(position);

        holder.tvTime.setText(item.getTime());
        holder.tvPortion.setText(item.getPortionLabel());
        holder.tvRepeat.setText(item.getRepeat());

        // Colour-code the portion chip
        int chipColor;
        switch (item.getPortion()) {
            case "S": chipColor = 0xFF4AAEDF; break;  // sky
            case "L": chipColor = 0xFFE8547A; break;  // pink
            default:  chipColor = 0xFFF5A623; break;  // amber
        }
        holder.tvPortion.setBackgroundTintList(
                android.content.res.ColorStateList.valueOf(chipColor));

        holder.btnDelete.setOnClickListener(v -> {
            if (deleteListener != null) deleteListener.onDelete(item);
        });
    }

    // ----------------------------------------------------------------

    static class ViewHolder extends RecyclerView.ViewHolder {
        TextView    tvTime, tvPortion, tvRepeat;
        ImageButton btnDelete;

        ViewHolder(@NonNull View itemView) {
            super(itemView);
            tvTime    = itemView.findViewById(R.id.tv_schedule_time);
            tvPortion = itemView.findViewById(R.id.tv_schedule_portion);
            tvRepeat  = itemView.findViewById(R.id.tv_schedule_repeat);
            btnDelete = itemView.findViewById(R.id.btn_delete_schedule);
        }
    }
}
