import React from "react";
import { createRoot } from "react-dom/client";
import MultiDatePickerComponent from "./components/MultiDatePickerComponent";

const container = document.getElementById("multi-date-picker-root");

if (container) {
  const root = createRoot(container);
  root.render(
    <MultiDatePickerComponent
      onChange={(dates) => {
        console.log("تاریخ‌های انتخاب شده:", dates);
        // اینجا می‌تونی داده‌ها رو به سرور بفرستی یا تو state ذخیره کنی
      }}
    />
  );
}
