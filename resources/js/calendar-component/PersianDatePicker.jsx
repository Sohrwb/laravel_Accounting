import React, { useState, useEffect } from "react";
import DatePicker from "react-multi-date-picker";
import persian from "react-date-object/calendars/persian";
import persian_fa from "react-date-object/locales/persian_fa";
import jalaali from "jalaali-js";

export default function PersianDatePicker({ inputName = "start_date" }) {
    const [value, setValue] = useState(null);
    const [gregorianValue, setGregorianValue] = useState("");

    // تبدیل اعداد فارسی به انگلیسی
    function toEnglishDigits(str) {
        const faNums = ["۰", "۱", "۲", "۳", "۴", "۵", "۶", "۷", "۸", "۹"];
        const enNums = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9"];
        let result = str;
        for (let i = 0; i < faNums.length; i++) {
            result = result.replace(new RegExp(faNums[i], "g"), enNums[i]);
        }
        return result;
    }

    // تبدیل تاریخ شمسی به میلادی با jalaali-js
    function toGregorianDate(shamsiDate) {
        if (!shamsiDate) return "";

        const dateStr = toEnglishDigits(shamsiDate);
        const parts = dateStr.split("/");
        if (parts.length !== 3) return "";

        const jy = parseInt(parts[0], 10);
        const jm = parseInt(parts[1], 10);
        const jd = parseInt(parts[2], 10);

        const { gy, gm, gd } = jalaali.toGregorian(jy, jm, jd);

        return `${gy.toString().padStart(4, "0")}-${gm.toString().padStart(2, "0")}-${gd.toString().padStart(2, "0")}`;
    }

    useEffect(() => {
        if (value) {
            const shamsi = value.format("YYYY/MM/DD");
            const gregorian = toGregorianDate(shamsi);
            setGregorianValue(gregorian);
        } else {
            setGregorianValue("");
        }
    }, [value]);

    return (
        <>
            <DatePicker
                value={value}
                onChange={setValue}
                calendar={persian}
                locale={persian_fa}
                format="YYYY/MM/DD"
                calendarPosition="bottom-right"
                style={{ direction: "rtl", fontSize: "1rem", padding: "0.5rem" }}
                inputClass="form-control"
                placeholder="تاریخ را انتخاب کنید"
            />
            <input type="hidden" name={inputName} value={gregorianValue} />
        </>
    );
}
