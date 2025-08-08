import React from "react";

export default function MultiDatePickerComponent({ onChange }) {
  return (
    <div>
      <p>کامپوننت تست</p>
      <button onClick={() => onChange(["2025-01-01"])}>تست تاریخ</button>
    </div>
  );
}
