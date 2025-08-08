import React from "react";
import ReactDOM from "react-dom/client";
import PersianDatePicker from "./calendar-component/PersianDatePicker";

ReactDOM.createRoot(document.getElementById("react-datepicker-root")).render(
  <PersianDatePicker inputName="start_date" />
);
