let $doctor, $date, $specialty, $hours;
let iRadio;

const noHoursAlert = `
<div class="alert alert-secondary" role="alert">
    <strong>Lo sentimos</strong>, no se encontraron horas disponibles 
    para el <strong>médico</strong> en el <strong>día</strong> seleccionado.
</div>`;

$(function () {
	$specialty = $('#specialty');
	$doctor = $('#doctor');
	$date = $('#date');
	$hours = $('#hours');

	$specialty.change(() => {
		const specialtyId = $specialty.val();
		const url = `/api/specialties/${specialtyId}/doctors`;
		$.getJSON(url, onDoctorsLoaded);
	});

	$doctor.change(loadHours);
	$date.change(loadHours);
});

function onDoctorsLoaded(doctors) {
	let htmlOptions = '';
	doctors.forEach(doctor => {
		htmlOptions += `<option value="${doctor.id}">${doctor.name}</option>`;
	});
	$doctor.html(htmlOptions);
	loadHours(); //efecto colateral al cambiar al doctor
}

function loadHours() {
	const selectedDate = $date.val();
	const doctorId = $doctor.val();

	const url = `/api/schedule/hours?date=${selectedDate}&doctor_id=${doctorId}`;
	$.getJSON(url, displayHours);
}

function displayHours(data) {
	if(!data.morning && !data.afternoon || data.morning.length==0 && data.afternoon==0) {

		$hours.html(noHoursAlert);
		return; 
	}
	let htmlHours = '';
	iRadio = 0;

	if (data.morning) {
		const morning_intervals = data.morning;
		morning_intervals.forEach(interval => {
			htmlHours += getRadioIntervalHtml(interval);
		});
	}
	if (data.afternoon) {
		const afternoon_intervals = data.afternoon;
		afternoon_intervals.forEach(interval => {
			htmlHours += getRadioIntervalHtml(interval);
		});
	}
	$hours.html(htmlHours);
}

function getRadioIntervalHtml(interval) {
	const text = `${interval.start} - ${interval.end}`;
	return `<div class="custom-control custom-radio custom-control-inline">
  <input type="radio" id="interval${iRadio}" name="scheduled_time" class="custom-control-input" value="${interval.start}" required>
  <label class="custom-control-label" for="interval${iRadio++}">${text}</label>
</div>`;
}