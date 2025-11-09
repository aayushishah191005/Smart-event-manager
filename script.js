async function showCountdown() {
  try {
    const res = await fetch('events.xml');
    const xmlText = await res.text();
    const parser = new DOMParser();
    const xml = parser.parseFromString(xmlText, "text/xml");
    const events = xml.getElementsByTagName("event");

    if (events.length === 0) {
      document.getElementById("countdown").innerText = "No upcoming events found.";
      return;
    }

    const now = new Date();
    const eventList = [];

    for (let i = 0; i < events.length; i++) {
      const name = events[i].getElementsByTagName("name")[0].textContent.trim();
      const dateStr = events[i].getElementsByTagName("date")[0].textContent.trim();
      const time = new Date(dateStr).getTime();
      if (!isNaN(time)) eventList.push({ name, dateStr, time });
    }

    eventList.sort((a, b) => a.time - b.time);
    const nextEvent = eventList.find(ev => ev.time > now.getTime());
    const countdownDiv = document.getElementById("countdown");

    if (!nextEvent) {
      countdownDiv.innerHTML = "🎉 No upcoming events — all done!";
      return;
    }

    const countDownDate = nextEvent.time;
    const interval = setInterval(() => {
      const now = new Date().getTime();
      const distance = countDownDate - now;
      if (distance < 0) {
        countdownDiv.innerHTML = `🎊 "${nextEvent.name}" is happening today!`;
        clearInterval(interval);
        return;
      }
      const days = Math.floor(distance / (1000 * 60 * 60 * 24));
      const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      const mins = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
      countdownDiv.innerHTML = `
        Next Event: <b>${nextEvent.name}</b><br>
        Starts in <b>${days} days</b>, ${hours} hrs, ${mins} mins
      `;
    }, 1000);
  } catch (err) {
    console.error("Countdown Error:", err);
    document.getElementById("countdown").innerText = "Could not load countdown.";
  }
}

showCountdown();
