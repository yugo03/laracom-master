@extends('layouts.front.master')

@section('content')
    <div id="app">
        <div class="m-auto w-50 m-5 p-5">
            <div id='calendar'></div>
        </div>
    </div>


    <script src='{{ asset('fullcalendar-6.1.21/dist/index.global.min.js') }}'></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'ja',
                height: 'auto',
                firstDay: 1,
                headerToolbar: {
                    left: "dayGridMonth,listMonth",
                    center: "title",
                    right: "today prev,next"
                },
                buttonText: {
                    today: '今月',
                    month: '月',
                    list: 'リスト'
                },
                noEventsContent: '案件はありません',
                eventSources: [ // ←★追記
                    {
                        url: '/get_events',
                    },
                ],
                eventSourceFailure() { // ←★追記
                    console.error('エラーが発生しました。');
                },
                eventMouseEnter(info) { // ←★追記
                    $(info.el).popover({
                        title: info.event.title,
                        content: info.event.extendedProps.description,
                        trigger: 'hover',
                        placement: 'top',
                        container: 'body',
                        html: true
                    });
                }
            });
            calendar.render();
        });
    </script>
@endsection
