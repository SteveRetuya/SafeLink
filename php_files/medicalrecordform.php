<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Medical Record Form</title>
        <link href="..\css_files\MedicalRecordCSS.css" rel="stylesheet" type="text/css">
    </head>

    <body>
    <?php include 'medicalrecordsformAlgo.php'; ?>
        <div class="form-container">
            <h2 class="toCenter">Medical Record Form</h2>

            <!-- Display messages -->
            <h3 class="toCenter"><?php if (isset($message)) echo $message; ?></h3>

            <!-- Render the form dynamically -->
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">

                <label for="patient-name">Patient Name:</label>
                <input type="text" id="patient-name" name="patient-name" value="<?= htmlspecialchars($user['patient_name'] ?? '') ?>" required>

                <label for="dob">Date of Birth:</label>
                <input type="date" id="dob" name="dob" value="<?= htmlspecialchars($user['date_of_birth'] ?? '') ?>" required>

                <label for="contact-info">Contact Information:</label>
                <input type="text" id="contact-info" name="contact-info" value="<?= htmlspecialchars($user['contact_info'] ?? '') ?>" placeholder="Phone number or email" required>

                <label for="insurance-details">Insurance Details:</label>
                <input type="text" id="insurance-details" name="insurance-details" value="<?= htmlspecialchars($user['insurance_details'] ?? '') ?>" required>

                <label for="allergies">List any allergies:</label>
                <textarea id="allergies" name="allergies" rows="4" placeholder="e.g., penicillin, peanuts"><?= htmlspecialchars($user['allergies'] ?? '') ?></textarea>

                <label for="surgeries">Surgeries (if any):</label>
                <textarea id="surgeries" name="surgeries" rows="4" placeholder="e.g., appendectomy, knee surgery"><?= htmlspecialchars($user['surgeries'] ?? '') ?></textarea>

                <label for="illnesses">Illnesses (if any):</label>
                <textarea id="illnesses" name="illnesses" rows="4" placeholder="e.g., diabetes, asthma"><?= htmlspecialchars($user['illnesses'] ?? '') ?></textarea>

                <label for="family-medical-history">Family Medical History:</label>
                <textarea id="family-medical-history" name="family-medical-history" rows="4" placeholder="e.g., heart disease, cancer"><?= htmlspecialchars($user['medical_history'] ?? '') ?></textarea>

                <label for="emergency-contact-number">Emergency Contact Number:</label>
                <input type="text" id="emergency-contact-number" name="emergency-contact-number" value="<?= htmlspecialchars($user['emergency_contact_number'] ?? '') ?>" placeholder="Enter Emergency Contact Number" required>

                <button type="submit">Submit Record</button>
            </form>

            <br / >


            <!-- Add a back button -->
            <button onclick="window.history.back();">Back</button>
        </div>

    </body>
</html>