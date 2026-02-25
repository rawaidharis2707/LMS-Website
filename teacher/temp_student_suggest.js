// Temporary file - this function needs to be added to remarks.html
function populateStudentSuggestions() {
    const datalist = document.getElementById('studentSuggestions');
    const studentInfo = document.getElementById('studentInfo');
    const session = getSession();
    const teacherId = session && session.userData ? (session.userData.teacherId || 'T001') : 'T001';

    // Get teacher's assignments to find their classes
    const assignments = getTeacherSubjectAssignments(teacherId);
    const uniqueClasses = [...new Set(assignments.map(a => a.className))];

    if (uniqueClasses.length === 0) {
        if (studentInfo) {
            studentInfo.textContent = 'No classes assigned';
            studentInfo.classList.add('text-danger');
        }
        return;
    }

    // Get all students from assigned classes
    let allStudents = [];
    uniqueClasses.forEach(className => {
        const classStudents = getStudentsByClass(className);
        allStudents = allStudents.concat(classStudents);
    });

    // Remove duplicates based on student ID
    const uniqueStudents = allStudents.filter((student, index, self) =>
        index === self.findIndex((s) => (s.id || s.roll) === (student.id || student.roll))
    );

    // Populate datalist
    datalist.innerHTML = '';
    uniqueStudents.forEach(student => {
        const option = document.createElement('option');
        option.value = `${student.name} - ${student.roll}`;
        datalist.appendChild(option);
    });

    if (studentInfo) {
        studentInfo.textContent = `${uniqueStudents.length} student(s) from your ${uniqueClasses.length} class(es)`;
        studentInfo.classList.add('text-success');
    }
}
