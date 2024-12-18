// moment.js language configuration
// language : korean (kr)
// author : Kyungwook, Park : https://github.com/kyungw00k

// This language config was incorrectly named 'kr' instead of 'ko'.
// In version 2.0.0, this will be deprecated and you should use 'ko' instead.
(function () {
    var lang = {
            months : "1월_2월_3월_4월_5월_6월_7월_8월_9월_10월_11월_12월".split("_"),
            monthsShort : "1월_2월_3월_4월_5월_6월_7월_8월_9월_10월_11월_12월".split("_"),
            weekdays : "일요일_월요일_화요일_수요일_목요일_금요일_토요일".split("_"),
            weekdaysShort : "일_월_화_수_목_금_토".split("_"),
            weekdaysMin : "일_월_화_수_목_금_토".split("_"),
            longDateFormat : {
                LT : "A h시 mm분",
                L : "YYYY.MM.DD",
                LL : "YYYY년 MMMM D일",
                LLL : "YYYY년 MMMM D일 LT",
                LLLL : "YYYY년 MMMM D일 dddd LT"
            },
            meridiem : function (hour, minute, isUpper) {
                return hour < 12 ? '오전' : '오후';
            },
            calendar : {
                sameDay : '오늘 LT',
                nextDay : '내일 LT',
                nextWeek : 'dddd LT',
                lastDay : '어제 LT',
                lastWeek : '지난주 dddd LT',
                sameElse : 'L'
            },
            relativeTime : {
                future : "%s 후",
                past : "%s 전",
                s : "몇초",
                ss : "%d초",
                m : "일분",
                mm : "%d분",
                h : "한시간",
                hh : "%d시간",
                d : "하루",
                dd : "%d일",
                M : "한달",
                MM : "%d달",
                y : "일년",
                yy : "%d년"
            },
            ordinal : function (number) {
                return '일';
            }
        };

    // Node
    if (typeof module !== 'undefined' && module.exports) {
        module.exports = lang;
    }
    // Browser
    if (typeof window !== 'undefined' && this.moment && this.moment.lang) {
        this.moment.lang('kr', lang);
    }
}());
