document.addEventListener('DOMContentLoaded', function() {
    const exercisesWrapper = document.getElementById('exercises-wrapper');
    const addExerciseButton = document.getElementById('add-exercise');

    function createExerciseRow(index, name = '', weight = '', reps = '', sets = '') {
        const row = document.createElement('div');
        row.className = 'exercise-row';
        row.style.display = 'flex';
        row.style.gap = '.5rem';
        row.style.marginBottom = '.75rem';

        const nameInput = document.createElement('input');
        nameInput.type = 'text';
        nameInput.name = 'exercise_names[]';
        nameInput.placeholder = 'Exercise name';
        nameInput.className = 'exercise-input';
        nameInput.style.flex = '2';
        nameInput.value = name;

        const weightInput = document.createElement('input');
        weightInput.type = 'text';
        weightInput.name = 'exercise_weights[]';
        weightInput.placeholder = '1kg';
        weightInput.className = 'exercise-input';
        weightInput.style.flex = '1';
        weightInput.value = weight;

        const repsInput = document.createElement('input');
        repsInput.type = 'text';
        repsInput.name = 'exercise_reps[]';
        repsInput.placeholder = 'Reps';
        repsInput.className = 'exercise-input';
        repsInput.style.flex = '1';
        repsInput.value = reps;

        const setsInput = document.createElement('input');
        setsInput.type = 'text';
        setsInput.name = 'exercise_sets[]';
        setsInput.placeholder = 'Sets';
        setsInput.className = 'exercise-input';
        setsInput.style.flex = '1';
        setsInput.value = sets;

        row.appendChild(nameInput);
        row.appendChild(weightInput);
        row.appendChild(repsInput);
        row.appendChild(setsInput);
        return row;
    }

    addExerciseButton.addEventListener('click', function() {
        const rowCount = exercisesWrapper.querySelectorAll('.exercise-row').length;
        exercisesWrapper.appendChild(createExerciseRow(rowCount + 1));
    });
});

function togglePassword(inputId, iconElement) {
    const password = document.getElementById(inputId);
    if (!password) {
        return;
    }

    const isHidden = password.type === "password";
    password.type = isHidden ? "text" : "password";

    if (iconElement) {
        iconElement.classList.toggle("fa-eye");
        iconElement.classList.toggle("fa-eye-slash");
    }
}

function escapeHtml(value) {
    return String(value)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#39;');
}

function show_workout_details(workout) {
    const container = document.getElementById('workout-details-container');
    if (!container) {
        alert('Workout details panel not found.');
        return;
    }

    if (!workout || typeof workout !== 'object') {
        container.style.display = 'none';
        alert('No workout data available.');
        return;
    }

    const exercises = Array.isArray(workout.exercises) ? workout.exercises : [];
    const exerciseFields = exercises.map((exercise, index) => {
        const name = typeof exercise === 'object' ? exercise.name : exercise;
        const weight = typeof exercise === 'object' ? exercise.weight : '';
        const reps = typeof exercise === 'object' ? exercise.reps : '';
        const sets = typeof exercise === 'object' ? exercise.sets : '';

        return `
            <div class="exercise-row" style="display:flex; gap:.5rem; margin-bottom:.75rem; padding:0.5rem;">
                <label style="flex:2; display:block; font-weight:700; margin-bottom:0.25rem;">Exercise</label>
                <label style="flex:1; display:block; font-weight:700; margin-bottom:0.25rem;">Weight</label>
                <label style="flex:1; display:block; font-weight:700; margin-bottom:0.25rem;">Sets</label>
                <label style="flex:1; display:block; font-weight:700; margin-bottom:0.25rem;">Reps</label>
            </div>

            <div class="exercise-row" style="display:flex; gap:.5rem; margin-bottom:.75rem;">
                <input type="text" name="exercise_names[]" value="${escapeHtml(name || '')}" placeholder="Exercise" style="flex:2; padding:0.5rem;" />
                <input type="text" name="exercise_weights[]" value="${escapeHtml(weight || '')}" placeholder="kg/lb" style="flex:1; padding:0.5rem;" />
                <input type="text" name="exercise_sets[]" value="${escapeHtml(sets || '')}" placeholder="Sets" style="flex:1; padding:0.5rem;" />
                <input type="text" name="exercise_reps[]" value="${escapeHtml(reps || '')}" placeholder="Reps" style="flex:1; padding:0.5rem;" />
            </div>
        `;
    }).join('');

    container.innerHTML = `
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1rem;">
            <h4>Workout details</h4>
            <button type="button" id="close-workout-details" style="background:none; border:none; cursor:pointer; font-size:1.25rem;">
                <i class="fa fa-window-close" aria-hidden="true"></i>
            </button>
        </div>
        <form id="workout-details-form" method="post">
            <input type="hidden" name="update_workout" value="1" />
            <input type="hidden" name="code_workout" value="${escapeHtml(workout.code_workout || '')}" />

            <div style="margin-bottom:1rem;">
                <label style="display:block; font-weight:700;">Name</label>
                <input type="text" name="name" value="${escapeHtml(workout.name || '')}" style="width:100%; padding:0.5rem;" />
            </div>

            <div id="workout-exercises-list">
                ${exerciseFields}
            </div>

            <input type="button" id="add-workout-exercise" style="margin-bottom:1rem;" value="+">
            <div>
                <input type="submit" value="Save workout" style="margin-right:0.75rem; background:linear-gradient(135deg, #7c3aed 0%, #60a5fa 100%); color:#fff; font-weight:700;">
            </div>
        </form>
    `;

    container.style.display = 'block';

    const addButton = document.getElementById('add-workout-exercise');
    if (addButton) {
        addButton.addEventListener('click', function() {
            const list = document.getElementById('workout-exercises-list');
            const count = list.querySelectorAll('.exercise-row').length;
            const field = document.createElement('div');
            field.className = 'exercise-row';
            field.style.display = 'flex';
            field.style.gap = '.5rem';
            field.style.marginBottom = '.75rem';
            field.innerHTML = `
                <input type="text" name="exercise_names[]" value="" placeholder="Exercise" style="flex:2; padding:0.5rem;" />
                <input type="text" name="exercise_weights[]" value="" placeholder="kg/lb" style="flex:1; padding:0.5rem;" />
                <input type="text" name="exercise_sets[]" value="" placeholder="Sets" style="flex:1; padding:0.5rem;" />
                <input type="text" name="exercise_reps[]" value="" placeholder="Reps" style="flex:1; padding:0.5rem;" />
            `;
            list.appendChild(field);
        });
    }

    const closeButton = document.getElementById('close-workout-details');
    if (closeButton) {
        closeButton.addEventListener('click', function() {
            container.style.display = 'none';
        });
    }
}
