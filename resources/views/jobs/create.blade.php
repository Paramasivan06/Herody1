<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Herody Job Application</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Center the form and make it responsive */
        html, body {
            height: 100%;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f0f4ff, #d9e8ff);
        }

        .application-section {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            min-height: 100vh;
        }

        .form-card {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            padding: 40px;
            width: 100%;
            max-width: 600px;
            box-sizing: border-box;
        }

        .form-title {
            font-size: 28px;
            font-weight: 700;
            color: #333333;
            text-align: center;
            margin-bottom: 10px;
        }

        .form-subtitle {
            font-size: 16px;
            color: #6c757d;
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group label {
            font-weight: 600;
        }

        .submit-button {
            width: 100%;
            font-size: 16px;
            font-weight: 600;
            background-color: #007bff;
            border: none;
            color: #ffffff;
            transition: background-color 0.3s ease;
        }

        .submit-button:hover {
            background-color: #0056b3;
        }

        .logo {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo img {
            width: 100px;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .form-card {
                padding: 20px;
            }

            .form-title {
                font-size: 24px;
            }

            .form-subtitle {
                font-size: 14px;
            }

            .submit-button {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>

<section class="application-section">
    <div class="form-card">
        <!-- Company Logo -->
        <div class="logo">
            <img src="{{ asset('assets/digital/assets/img/logo.png') }}" alt="Herody Logo">
        </div>

        <h2 class="form-title">Job Application</h2>
        <p class="form-subtitle">Join our team by filling out the details below.</p>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('jobs.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" required class="form-control" placeholder="Enter your full name">
            </div>
            
            <div class="form-group">
                <label for="mobile_number">Mobile Number</label>
                <input type="tel" id="mobile_number" name="mobile_number" required class="form-control" placeholder="Enter your mobile number">
            </div>
            
            <div class="form-group">
                <label for="mobile_number">Email</label>
                <input type="tel" id="email" name="email" required class="form-control" placeholder="Enter your email">
            </div>
            
            <div class="form-group">
                <label for="location">Location</label>
                <input type="text" id="location" name="location" required class="form-control" placeholder="Enter your location">
            </div>
            
            <div class="form-group">
                <label for="highest_qualification">Highest Qualification</label>
                <select id="highest_qualification" name="highest_qualification" class="form-control">
                    <option value="UG">Undergraduate (UG)</option>
                    <option value="PG">Postgraduate (PG)</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="qualification">Specialization</label>
                <input type="text" id="qualification" name="qualification" required class="form-control" placeholder="Enter your field of study">
            </div>
            <div class="form-group">
                <label for="career_id">Select Career Position</label>
                <select name="career_id" id="career_id" class="form-control" required>
                    @foreach ($careers as $career)
                        <option value="{{ $career->id }}">{{ $career->position }}</option>
                    @endforeach
                </select>
            </div>
            
            <!--<div class="form-group">-->
            <!--    <label for="resume_path">Resume Upload</label>-->
            <!--    <input type="file" id="resume" name="resume_path" class="form-control-file" required>-->
            <!--</div>-->
            
            <button type="submit" class="btn btn-primary submit-button">Submit Application</button>
        </form>
    </div>
</section>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
