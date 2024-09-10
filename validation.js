document.getElementById('studentForm').addEventListener('submit', function(e) {
    var name = document.getElementById('studentName').value;
    var major = document.getElementById('studentMajor').value;
    var course = document.getElementById('course').value;

    if (name === '' || major === '' || course === '') {
        alert("Please fill all fields.");
        e.preventDefault(); // Prevent form submission if validation fails
    }
});
