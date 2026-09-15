document.addEventListener('DOMContentLoaded', () => {
  // 1. Get current Local Date, Local DateTime, and Local Time
  const now = new Date();
  
  const year = now.getFullYear();
  const month = String(now.getMonth() + 1).padStart(2, '0');
  const day = String(now.getDate()).padStart(2, '0');
  const hours = String(now.getHours()).padStart(2, '0');
  const minutes = String(now.getMinutes()).padStart(2, '0');

  const currentDate = `${year}-${month}-${day}`;
  const currentDateTime = `${year}-${month}-${day}T${hours}:${minutes}`;
  const currentTime = `${hours}:${minutes}`; // Format: HH:mm

  // 2. Update ALL date inputs (type="date")
  document.querySelectorAll('.date_today').forEach(input => {
    input.value = currentDate;
  });

  // 3. Update ALL datetime-local inputs (type="datetime-local")
  document.querySelectorAll('.date_time_today').forEach(input => {
    input.value = currentDateTime;
  });

  // 4. Update ALL time inputs (type="time")
  document.querySelectorAll('.time_today').forEach(input => {
    input.value = currentTime;
  });
});