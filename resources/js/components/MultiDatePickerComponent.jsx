import React, { useState } from "react";
import DatePicker from "react-multi-date-picker";

import persian from "react-date-object/calendars/persian";
import persian_fa from "react-date-object/locales/fa";

export default function MultiDatePickerComponent({ value: initialValue, onChange }) {
    const [value, setValue] = useState(initialValue || []);

    function handleChange(newValue) {
        setValue(newValue);
        if (onChange) onChange(newValue);
    }

    return (
        <DatePicker
            value={value}
            onChange={handleChange}
            multiple
            calendar={persian}
            locale={persian_fa}
        />
    );
}
