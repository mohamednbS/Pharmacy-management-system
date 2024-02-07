<!DOCTYPE html>
<html lang='en'>
  <head>
    <meta charset='utf-8' />
    <style>
    #calendar-container {
        position: auto;
        inset-block-start: 0;
        inset-inline-start: 0;
        inset-inline-end: 0;
        inset-block-end: 0;
    }
    #calendar {
        margin: 10px auto;
        padding: 10px;
        max-inline-size: 1100px;
        block-size: 700px;
    }

    </style>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>


   <script>
   create_UUID = () => {
    let dt = new Date().getTime();
    const uuid = 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, c => {
        let r = (dt + Math.random() * 16) % 16 | 0;
        dt = Math.floor(dt / 16);
        return (c == 'x' ? r :(r&0x3|0x8)).toString(16);
    });
    return uuid;
}
    document.addEventListener('livewire:load', function () {
        const Calendar = FullCalendar.Calendar;
        const calendarEl = document.getElementById('calendar');
        const calendar = new Calendar(calendarEl, {
        locale: '{{ config('locale', 'fr') }}',
        headerToolbar: { left : 'prev,next,today', center : 'title', right : 'dayGridMonth,timeGridWeek,timeGridDay,listWeek' },
        events: JSON.parse(@this.events),
        editable: true,                
        eventResize: info => @this.eventChange(info.event),
        eventDrop: info => @this.eventChange(info.event),
        selectable: true,

        /* formulaire ajout event*/ 
          select: arg => {
            const title = prompt('Titre :');
            const id = create_UUID();
            if (title) {
                calendar.addEvent({
                    id: id,
                    title: title,   
                    start: arg.start,
                    end: arg.end,
                    allDay: arg.allDay
                });
                @this.eventAdd(calendar.getEventById(id));
            };
            calendar.unselect();
        },
        /* FIN formulaire ajout event*/ 
        });
        calendar.render();
    });
 
    </script>
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/main.min.css' rel='stylesheet' />

  </head>
  <body>
    <div>
    <div id='calendar-container' wire:ignore>
        <div id='calendar'></div>
    </div>
</div>
  </body>
</html>