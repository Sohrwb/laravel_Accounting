document.addEventListener('DOMContentLoaded', function () {
    function formatNumber(num) {
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    function unformatNumber(str) {
        return parseFloat(str.replace(/,/g, ''));
    }

    function numberToPersianWords(number) {
        const units = ['', 'هزار', 'میلیون', 'میلیارد', 'تریلیون'];
        const persianNumbers = [
            '', 'یک', 'دو', 'سه', 'چهار', 'پنج', 'شش', 'هفت', 'هشت', 'نه',
            'ده', 'یازده', 'دوازده', 'سیزده', 'چهارده', 'پانزده',
            'شانزده', 'هفده', 'هجده', 'نوزده'
        ];
        const tens = ['', '', 'بیست', 'سی', 'چهل', 'پنجاه', 'شصت', 'هفتاد', 'هشتاد', 'نود'];
        const hundreds = ['', 'صد', 'دویست', 'سیصد', 'چهارصد', 'پانصد', 'ششصد', 'هفتصد', 'هشتصد', 'نهصد'];

        function convertThreeDigits(num) {
            let word = '';
            const hundred = Math.floor(num / 100);
            const remainder = num % 100;
            const ten = Math.floor(remainder / 10);
            const unit = remainder % 10;

            if (hundred > 0) word += hundreds[hundred];
            if (remainder > 0) {
                if (word !== '') word += ' و ';
                if (remainder < 20) word += persianNumbers[remainder];
                else {
                    word += tens[ten];
                    if (unit > 0) word += ' و ' + persianNumbers[unit];
                }
            }
            return word;
        }

        if (number === 0) return 'صفر';
        let parts = [];
        let i = 0;

        while (number > 0) {
            const part = number % 1000;
            if (part !== 0) {
                let partWord = convertThreeDigits(part);
                if (units[i]) partWord += ' ' + units[i];
                parts.unshift(partWord);
            }
            number = Math.floor(number / 1000);
            i++;
        }

        return parts.join(' و ');
    }

    document.querySelectorAll('.formatted-amount').forEach((input) => {
        input.addEventListener('input', function () {
            const wrapper = input.closest('div.mb-3').parentElement;
            const rawInput = wrapper.querySelector('.amount-hidden');
            const scoreOutput = wrapper.querySelector('.score-output');
            const scoreHidden = wrapper.querySelector('.score-hidden');
            const textDiv = wrapper.querySelector('.amount-in-words');

            let raw = unformatNumber(input.value);
            if (!isNaN(raw)) {
                rawInput.value = raw;
                input.value = formatNumber(raw);

                if (scoreOutput && scoreHidden) {
                    const score = raw * 2.5;
                    scoreOutput.value = formatNumber(score.toFixed(0));
                    scoreHidden.value = score.toFixed(2);
                }

                if (textDiv) {
                    textDiv.textContent = numberToPersianWords(raw) + ' تومان';
                }
            } else {
                rawInput.value = '';
                if (scoreOutput) scoreOutput.value = '';
                if (scoreHidden) scoreHidden.value = '';
                if (textDiv) textDiv.textContent = '';
            }
        });
    });
});
