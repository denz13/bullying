<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Safe Haven | Immaculate Conception School of Naic Inc. - Anti-Bullying Initiative</title>
    <link rel="icon" type="image/png" href="{{ asset('image/logo.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('image/logo.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
   <style>
        :root {
            --primary: #1a4b84;      /* Professional blue */
            --secondary: #c9a227;    /* Gold accent */
            --accent: #2e8b57;       /* Friendly green */
            --light: #f8f5f0;        /* Off-white background */
            --dark: #2c3e50;         /* Dark blue-gray */
            --success: #2e8b57;      /* Sea green */
            --crisis: #e67e22;       /* Friendly orange for urgent matters */
            --text: #333333;         /* Main text color */
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: var(--light);
            color: var(--text);
            line-height: 1.6;
        }
        
        /* Header Styles */
        header {
            background: linear-gradient(135deg, var(--primary), #0d2d54);
            color: white;
            padding: 1.5rem 1rem;
            text-align: center;
            box-shadow: 0 2px 15px rgba(0,0,0,0.1);
            position: relative;
            overflow: hidden;
        }
        
        .header-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        
        .school-brand {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            width: 100%;
        }
        
        .school-logo {
            width: 80px;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
        }
        
        .school-logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
        
        .school-logo i {
            font-size: 2.5rem;
            color: var(--primary);
        }
        
        .school-info {
            text-align: center;
        }
        
        .school-info h1 {
            font-size: 1.8rem;
            margin-bottom: 0.3rem;
            text-shadow: 1px 1px 3px rgba(0,0,0,0.3);
            text-align: center;
        }
        
        .school-info p {
            font-size: 16px;
            opacity: 0.9;
            text-align: center;
            margin-right: 100px;
        }
        
        .initiative-title {
            font-size: 2.2rem;
            margin: 1rem 0;
            color: white;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        
        .initiative-subtitle {
            font-size: 1.2rem;
            max-width: 800px;
            margin: 0 auto;
            opacity: 0.9;
        }
        
        /* Navigation */
        nav {
            background-color: var(--dark);
            padding: 0.8rem;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        nav ul {
            display: flex;
            justify-content: center;
            list-style: none;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        nav li {
            margin: 0 1.2rem;
        }
        
        nav a {
            color: white;
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            transition: all 0.3s;
            font-weight: 500;
            display: flex;
            align-items: center;
        }
        
        nav a i {
            margin-right: 0.5rem;
        }
        
        nav a:hover {
            background-color: rgba(255,255,255,0.15);
            transform: translateY(-2px);
        }
        
        nav a.login-btn {
            background-color: var(--secondary);
            color: white;
            border-radius: 20px;
            padding: 0.6rem 1.5rem;
            font-weight: 600;
        }
        
        nav a.login-btn:hover {
            background-color: #b8941f;
            transform: translateY(-2px);
        }
        
        /* Main Content */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem 1rem;
        }
        
        .hero {
            background: linear-gradient(rgba(26, 75, 132, 0.85), rgba(13, 45, 84, 0.9)), url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100"><rect width="100" height="100" fill="%231a4b84"/><path d="M0 0L100 100M100 0L0 100" stroke="%230d2d54" stroke-width="2"/></svg>');
            background-size: cover;
            color: white;
            padding: 4rem 2rem;
            text-align: center;
            border-radius: 10px;
            margin-bottom: 3rem;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        
        .hero h2 {
            font-size: 2.5rem;
            margin-bottom: 1.5rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        
        .hero p {
            font-size: 1.2rem;
            max-width: 800px;
            margin: 0 auto 2rem;
            line-height: 1.8;
        }
        
        .btn {
            display: inline-block;
            background-color: var(--secondary);
            color: white;
            padding: 0.9rem 2rem;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            font-size: 1.1rem;
            text-decoration: none;
            transition: all 0.3s;
            font-weight: 600;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            margin: 0.5rem;
        }
        
        .btn:hover {
            background-color: #b8941f;
            transform: translateY(-3px);
            box-shadow: 0 6px 8px rgba(0,0,0,0.15);
        }
        
        .btn-crisis {
            background-color: var(--crisis);
        }
        
        .btn-crisis:hover {
            background-color: #d35400;
        }
        
        .section-title {
            text-align: center;
            margin: 3rem 0 2rem;
            color: var(--dark);
            position: relative;
            padding-bottom: 1rem;
        }
        
        .section-title::after {
            content: '';
            display: block;
            width: 100px;
            height: 4px;
            background: linear-gradient(to right, var(--primary), var(--secondary));
            margin: 0.8rem auto;
            border-radius: 2px;
        }
        
        /* Features Section */
        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }
        
        .feature-card {
            background-color: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            text-align: center;
            transition: transform 0.3s, box-shadow 0.3s;
            border-top: 4px solid var(--primary);
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        
        .feature-icon {
            font-size: 2.8rem;
            color: var(--primary);
            margin-bottom: 1.5rem;
        }
        
        .feature-card h3 {
            color: var(--dark);
            margin-bottom: 1rem;
            font-size: 1.4rem;
        }
        
        /* Forms */
        .form-container {
            background-color: white;
            padding: 2.5rem;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            margin-bottom: 3rem;
            border-left: 5px solid var(--primary);
        }
        
        .about-paragraphs {
            text-align: justify;
            line-height: 1.8;
            word-spacing: 0.1em;
            letter-spacing: 0.02em;
        }
        
        .about-paragraphs p {
            margin-bottom: 1.5rem;
            text-align: justify;
        }
        
        .form-intro {
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid #eee;
        }
        
        .form-group {
            margin-bottom: 1.8rem;
        }
        
        label {
            display: block;
            margin-bottom: 0.7rem;
            font-weight: 600;
            color: var(--dark);
        }
        
        input, textarea, select {
            width: 100%;
            padding: 1rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
            transition: border 0.3s;
        }
        
        input:focus, textarea:focus, select:focus {
            border-color: var(--primary);
            outline: none;
            box-shadow: 0 0 0 2px rgba(26, 75, 132, 0.2);
        }
        
        textarea {
            min-height: 150px;
            resize: vertical;
        }
        
        .checkbox-group {
            display: flex;
            align-items: flex-start;
            margin-bottom: 1.5rem;
        }
        
        .checkbox-group input {
            width: auto;
            margin-right: 0.8rem;
            margin-top: 0.3rem;
        }
        
        .confidentiality-notice {
            background-color: #f0f7ff;
            padding: 1.5rem;
            border-radius: 8px;
            margin: 1.5rem 0;
            border-left: 4px solid var(--primary);
        }
        
        .confidentiality-notice h4 {
            color: var(--primary);
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
        }
        
        .confidentiality-notice h4 i {
            margin-right: 0.7rem;
        }
        
        /* Resources */
        .resources {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }
        
        .resource-card {
            background-color: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: transform 0.3s;
        }
        
        .resource-card:hover {
            transform: translateY(-5px);
        }
        
        .resource-card h3 {
            color: var(--primary);
            margin-bottom: 1.2rem;
            padding-bottom: 0.8rem;
            border-bottom: 1px solid #eee;
            display: flex;
            align-items: center;
        }
        
        .resource-card h3 i {
            margin-right: 0.7rem;
        }
        
        .resource-card ul {
            list-style: none;
        }
        
        .resource-card li {
            margin-bottom: 0.8rem;
            padding-left: 1.5rem;
            position: relative;
        }
        
        .resource-card li:before {
            content: '•';
            color: var(--secondary);
            font-weight: bold;
            position: absolute;
            left: 0;
        }
        
        .resource-card a {
            color: var(--primary);
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .resource-card a:hover {
            color: var(--secondary);
            text-decoration: underline;
        }
        
        /* Emergency Banner */
        .emergency-banner {
            background: linear-gradient(to right, var(--crisis), #e67e22);
            color: white;
            padding: 1.2rem;
            text-align: center;
            border-radius: 8px;
            margin: 2rem 0;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        
        .emergency-banner h3 {
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .emergency-banner h3 i {
            margin-right: 0.7rem;
        }
        
        /* Footer */
        footer {
            background: linear-gradient(to right, var(--dark), #1a252f);
            color: white;
            padding: 3rem 1rem 2rem;
            margin-top: 3rem;
        }
        
        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
        }
        
        .footer-section h3 {
            margin-bottom: 1.5rem;
            position: relative;
            padding-bottom: 0.7rem;
        }
        
        .footer-section h3::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 50px;
            height: 2px;
            background-color: var(--secondary);
        }
        
        .footer-section p, .footer-section li {
            margin-bottom: 0.8rem;
            opacity: 0.8;
        }
        
        .footer-section ul {
            list-style: none;
        }
        
        .footer-section a {
            color: white;
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .footer-section a:hover {
            color: var(--secondary);
        }
        
        .copyright {
            text-align: center;
            padding-top: 2rem;
            margin-top: 2rem;
            border-top: 1px solid rgba(255,255,255,0.1);
            opacity: 0.7;
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .school-brand {
                flex-direction: column;
                text-align: center;
            }
            
            .school-logo {
                margin-right: 0;
                margin-bottom: 1rem;
            }
            
            .school-info {
                text-align: center;
            }
            
            .school-info p {
                margin-right: 0;
                text-align: center;
            }
            
            nav {
                padding: 0.6rem 0.5rem;
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }
            
            nav ul {
                flex-direction: row;
                justify-content: flex-start;
                align-items: center;
                gap: 0.3rem;
                padding: 0;
                min-width: max-content;
            }
            
            nav li {
                margin: 0;
                flex-shrink: 0;
            }
            
            nav a {
                padding: 0.5rem 0.8rem;
                font-size: 0.85rem;
                white-space: nowrap;
            }
            
            nav a i {
                margin-right: 0.3rem;
                font-size: 0.9rem;
            }
            
            nav a.login-btn {
                display: none;
            }
            
            .hero {
                padding: 3rem 1.5rem;
            }
            
            .hero h2 {
                font-size: 2rem;
            }
            
            .initiative-title {
                font-size: 1.8rem;
            }
            
            .form-container {
                padding: 1.5rem;
            }
        }
        
        /* Confirmation Messages */
        .confirmation {
            display: none;
            background: linear-gradient(to right, var(--success), #3cb371);
            color: white;
            padding: 2rem;
            border-radius: 10px;
            text-align: center;
            margin-bottom: 2rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .confirmation h3 {
            margin-bottom: 1rem;
            font-size: 1.5rem;
        }
        
        .inspiration-section {
            background-color: white;
            padding: 2rem;
            border-radius: 10px;
            margin: 2rem 0;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            text-align: center;
            border-top: 4px solid var(--secondary);
        }
        
        .inspiration-section h3 {
            color: var(--primary);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .inspiration-section h3 i {
            margin-right: 0.7rem;
        }
        
        .inspiration-text {
            font-style: italic;
            line-height: 1.8;
            max-width: 800px;
            margin: 0 auto;
            color: var(--dark);
        }
        
        /* New Professional Elements */
        .stats-section {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin: 3rem 0;
        }
        
        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 3px 10px rgba(0,0,0,0.08);
            transition: transform 0.3s;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
        }
        
        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            color: var(--primary);
            margin-bottom: 0.5rem;
        }
        
        .stat-label {
            color: var(--dark);
            font-weight: 500;
        }
        
        .testimonial-section {
            background-color: white;
            padding: 3rem 2rem;
            border-radius: 10px;
            margin: 3rem 0;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            text-align: center;
        }
        
        .testimonial {
            max-width: 800px;
            margin: 0 auto;
            font-style: italic;
            color: var(--dark);
            line-height: 1.8;
        }
        
        .testimonial-author {
            margin-top: 1.5rem;
            font-weight: 600;
            color: var(--primary);
        }
        
        .team-section {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin: 3rem 0;
        }
        
        .team-member {
            background-color: white;
            padding: 2rem;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: transform 0.3s;
        }
        
        .team-member:hover {
            transform: translateY(-5px);
        }
        
        .member-photo {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background-color: #f0f0f0;
            margin: 0 auto 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            color: var(--primary);
        }
        
        .member-name {
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 0.5rem;
        }
        
        .member-role {
            color: var(--primary);
            margin-bottom: 1rem;
        }
        
        .faq-section {
            margin: 3rem 0;
        }
        
        .faq-item {
            background-color: white;
            margin-bottom: 1rem;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 3px 10px rgba(0,0,0,0.05);
        }
        
        .faq-question {
            padding: 1.5rem;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: 600;
            color: var(--dark);
            transition: background-color 0.3s;
        }
        
        .faq-question:hover {
            background-color: #f9f9f9;
        }
        
        .faq-answer {
            padding: 0 1.5rem;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s, padding 0.3s;
        }
        
        .faq-item.active .faq-answer {
            padding: 0 1.5rem 1.5rem;
            max-height: 500px;
        }
        
        .faq-toggle {
            transition: transform 0.3s;
        }
        
        .faq-item.active .faq-toggle {
            transform: rotate(180deg);
        }
    </style>
</head>
<body>
    <!-- Header Section -->
    <header>
        <div class="header-content">
            <div class="school-brand">
                <div class="school-logo">
                    <img src="{{ asset('image/logo.png') }}" alt="Immaculate Conception School of Naic Inc. Logo">
                </div>
                <div class="school-info">
                    <h1>Immaculate Conception School of Naic Inc.</h1>
                    <p>Education for Mind, Body, and Character</p>
                </div>
            </div>
            <h1 class="initiative-title">Safe Haven</h1>
            <p class="initiative-subtitle">A Comprehensive Approach to Bullying Prevention and Student Support</p>
        </div>
    </header>
    
    <!-- Navigation -->
    <nav>
        <ul>
            <li><a href="#home"><i class="fas fa-home"></i> Home</a></li>
            <li><a href="#share"><i class="fas fa-share-alt"></i> Share</a></li>
            <li><a href="#counseling"><i class="fas fa-hands-helping"></i> Support</a></li>
            <li><a href="#resources"><i class="fas fa-life-ring"></i> Resources</a></li>
            <li><a href="#about"><i class="fas fa-info-circle"></i> About</a></li>
            <li><a href="{{ route('login') }}" class="login-btn"><i class="fas fa-sign-in-alt"></i> Login</a></li>
        </ul>
    </nav>
    
    <!-- Main Content -->
    <div class="container">
        <!-- Home Section -->
        <section id="home">
            <div class="hero">
                <h2>Creating a Community of Respect and Compassion</h2>
                <p>At Immaculate Conception School of Naic Inc., we believe every student deserves to learn in a safe, nurturing environment free from fear and intimidation.</p>
                <div class="emergency-banner">
                    <h3><i class="fas fa-exclamation-triangle"></i> Urgent Assistance</h3>
                    <p>If you need immediate help, contact school administration at <a href="tel:09061007363" style="color: white; text-decoration: underline;">09061007363</a></p>
                </div>
                <a href="#share" class="btn"><i class="fas fa-share-alt"></i> Share Your Experience</a>
                <a href="#counseling" class="btn btn-crisis"><i class="fas fa-hands-helping"></i> Request Support</a>
            </div>
            
            <!-- Statistics Section -->
            <div class="stats-section">
                <div class="stat-card">
                    <div class="stat-number">95%</div>
                    <div class="stat-label">Reports Handled Within 24 Hours</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">1000+</div>
                    <div class="stat-label">Students Supported This Year</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">12</div>
                    <div class="stat-label">Anti-Bullying Advocates</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">100%</div>
                    <div class="stat-label">Confidentiality Guaranteed</div>
                </div>
            </div>
            
            <h2 class="section-title">Our Support Approach</h2>
            <div class="features">
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-shield-alt"></i></div>
                    <h3>Confidential & Safe</h3>
                    <p>All reports are handled with strict confidentiality by our trained guidance counselors.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-heart"></i></div>
                    <h3>Compassionate Response</h3>
                    <p>We respond with compassion, focusing on healing and restoration for all involved.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-hands"></i></div>
                    <h3>Guidance Support</h3>
                    <p>Our school guidance and club organizations provide emotional support and life skills training.</p>
                </div>
            </div>
            
            <!-- Testimonial Section -->
            <div class="testimonial-section">
                <h2 class="section-title">Student Experiences</h2>
                <div class="testimonial">
                    "After I reported bullying through Safe Haven, the guidance counselors helped me feel safe again. They didn't just stop the bullying - they helped me heal and regain my confidence."
                </div>
                <div class="testimonial-author">- Grade 9 Student</div>
            </div>
            
            <div class="inspiration-section">
                <h3><i class="fas fa-quote-left"></i> Words of Encouragement</h3>
                <p class="inspiration-text">"Be the change you wish to see in the world. Your courage to speak up creates a safer environment for everyone in our school community."</p>
            </div>
        </section>
        
        <!-- Share Experience Section -->
        <section id="share">
            <h2 class="section-title">Share Your Experience</h2>
            <div class="form-container">
                <div class="form-intro">
                    <p>Sharing your experience is the first step toward healing and creating positive change. Your voice matters, and by speaking up, you help make our school safer for everyone.</p>
                </div>
                
                <div class="confidentiality-notice">
                    <h4><i class="fas fa-lock"></i> Your Privacy Matters</h4>
                    <p>All information shared through this form is strictly confidential and will only be accessed by our trained guidance counselors. You may choose to remain anonymous if you prefer.</p>
                </div>
                
                <form id="experience-form" method="POST" action="{{ route('share-experience.store') }}">
                    @csrf
                    <div class="form-group">
                        <label for="type_experience">Type of Experience</label>
                        <select id="type_experience" name="type_experience" required>
                            <option value="">Please select one</option>
                            <option value="verbal">Verbal Bullying (name-calling, teasing)</option>
                            <option value="physical">Physical Bullying (hitting, pushing)</option>
                            <option value="social">Social Bullying (exclusion, rumors)</option>
                            <option value="cyber">Cyberbullying (online harassment)</option>
                            <option value="other">Other Form of Bullying</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="content">Please describe what happened</label>
                        <textarea id="content" name="content" placeholder="Include details about the incident, when and where it occurred, who was involved, and how it made you feel..." required></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="type_of_support">What kind of support would be most helpful to you?</label>
                        <textarea id="type_of_support" name="type_of_support" placeholder="Are you looking for counseling, mediation, guidance, or other forms of support?"></textarea>
                    </div>
                    
                    <div class="checkbox-group">
                        <input type="checkbox" id="is_anonymously" name="is_anonymously" value="1" checked>
                        <label for="is_anonymously">Submit anonymously (your identity will not be recorded)</label>
                    </div>
                    
                    <button type="submit" class="btn"><i class="fas fa-paper-plane"></i> Share Your Experience</button>
                </form>
                
                <div id="experience-confirmation" class="confirmation">
                    <h3>Thank You for Your Courage</h3>
                    <p>Your experience has been recorded and will be reviewed by our guidance team. It takes strength to speak up, and by doing so, you're helping create a safer school community.</p>
                    <p>If you provided contact information and requested follow-up, a counselor will reach out to you within 24 hours.</p>
                </div>
            </div>
        </section>
        
        <!-- Counseling Section -->
        <section id="counseling">
            <h2 class="section-title">Request Support</h2>
            <div class="form-container">
                <div class="form-intro">
                    <p>Our team of trained counselors and guidance staff are here to provide emotional and psychological support. Please fill out this form to request assistance.</p>
                </div>
                
                <form id="counseling-form" method="POST" action="{{ route('request-counseling.store') }}">
                    @csrf
                    <div class="form-group">
                        <label for="fullname">Your Name (optional)</label>
                        <input type="text" id="fullname" name="fullname" placeholder="If you prefer to remain anonymous, leave this blank">
                    </div>
                    
                    <div class="form-group">
                        <label for="grade_section">Grade & Section</label>
                        <input type="text" id="grade_section" name="grade_section" placeholder="e.g., Grade 7 - Section A">
                    </div>
                    
                    <div class="form-group">
                        <label for="contact_details">How can we contact you? (optional)</label>
                        <input type="text" id="contact_details" name="contact_details" placeholder="Email, phone number, or other preferred contact method">
                    </div>
                    
                    <div class="form-group">
                        <label for="urgent_level">Urgency Level</label>
                        <select id="urgent_level" name="urgent_level" required>
                            <option value="">Please select one</option>
                            <option value="low">I'd like to talk when convenient</option>
                            <option value="medium">I'd like to connect in the next few days</option>
                            <option value="high">I need to speak with someone as soon as possible</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="counseling_content">What would you like to discuss with a counselor?</label>
                        <textarea id="counseling_content" name="content" placeholder="Please share any information that would help us understand how to best support you..." required></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="support_method">Preferred Support Method</label>
                        <select id="support_method" name="support_method">
                            <option value="">No preference</option>
                            <option value="in-person">In-person meeting</option>
                            <option value="phone">Phone call</option>
                            <option value="group">Group support session</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-crisis"><i class="fas fa-hands-helping"></i> Request Support</button>
                </form>
                
                <div id="counseling-confirmation" class="confirmation">
                    <h3>Support Request Received</h3>
                    <p>Thank you for reaching out. Our guidance team will contact you using your preferred method based on the urgency level you selected.</p>
                    <p>If this is an emergency, please contact school administration immediately at <a href="tel:09061007363" style="color: white; text-decoration: underline;">09061007363</a>.</p>
                </div>
            </div>
        </section>
        
        <!-- Resources Section -->
        <section id="resources">
            <h2 class="section-title">Resources & Support</h2>
            <div class="resources">
                <div class="resource-card">
                    <h3><i class="fas fa-hands-helping"></i> Guidance Services</h3>
                    <ul>
                        <li>Individual counseling sessions</li>
                        <li>Peer mediation programs</li>
                        <li>Life skills training</li>
                        <li>Group support sessions</li>
                        <li>Parent consultation services</li>
                    </ul>
                </div>
                
                <div class="resource-card">
                    <h3><i class="fas fa-file-alt"></i> School Policies</h3>
                    <ul>
                        <li><a href="#">Anti-Bullying Policy</a></li>
                        <li><a href="#">Student Code of Conduct</a></li>
                        <li><a href="#">Disciplinary Procedures</a></li>
                        <li><a href="#">Parent & Student Handbook</a></li>
                    </ul>
                </div>
                
                <div class="resource-card">
                    <h3><i class="fas fa-book"></i> Educational Resources</h3>
                    <ul>
                        <li><a href="#">Recognizing Bullying Behaviors</a></li>
                        <li><a href="#">Building Healthy Relationships</a></li>
                        <li><a href="#">Digital Citizenship & Online Safety</a></li>
                        <li><a href="#">Conflict Resolution Skills</a></li>
                    </ul>
                </div>
            </div>
            
            <!-- FAQ Section -->
            <div class="faq-section">
                <h2 class="section-title">Frequently Asked Questions</h2>
                
                <div class="faq-item">
                    <div class="faq-question">
                        What happens after I report bullying?
                        <span class="faq-toggle"><i class="fas fa-chevron-down"></i></span>
                    </div>
                    <div class="faq-answer">
                        <p>Our guidance counselors review all reports confidentially. They will assess the situation and determine the appropriate response, which may include meeting with involved students, contacting parents, or implementing protective measures. In all cases, we prioritize the safety and well-being of the reporting student.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        Will the person I report know it was me?
                        <span class="faq-toggle"><i class="fas fa-chevron-down"></i></span>
                    </div>
                    <div class="faq-answer">
                        <p>If you choose to report anonymously, your identity will not be disclosed. Even if you provide your name, our counselors handle situations with discretion and only share information on a need-to-know basis to protect your privacy and safety.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        What if I'm not sure if what I experienced is bullying?
                        <span class="faq-toggle"><i class="fas fa-chevron-down"></i></span>
                    </div>
                    <div class="faq-answer">
                        <p>If something has made you feel uncomfortable, unsafe, or distressed, it's worth reporting. Our counselors are trained to assess situations and provide appropriate support, regardless of whether it meets a strict definition of bullying.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        Can I request a specific counselor?
                        <span class="faq-toggle"><i class="fas fa-chevron-down"></i></span>
                    </div>
                    <div class="faq-answer">
                        <p>Yes, you can indicate if you have a preference for a specific counselor. We will do our best to accommodate your request while ensuring you receive timely support.</p>
                    </div>
                </div>
            </div>
            
            <div class="inspiration-section">
                <h3><i class="fas fa-hands-helping"></i> Club Organizations</h3>
                <p class="inspiration-text">Our various school clubs provide additional support through peer mentoring, educational activities, and community-building events that promote respect and inclusion.</p>
                <p style="margin-top: 1rem;">Visit our guidance office to learn more about getting involved in our student organizations.</p>
            </div>
        </section>
        
        <!-- About Section -->
        <section id="about">
            <h2 class="section-title">About Safe Haven</h2>
            <div class="form-container about-paragraphs">
                <p>Safe Haven is Immaculate Conception School of Naic Inc.'s comprehensive anti-bullying initiative, rooted in our values of compassion, dignity, and respect for all persons.</p>
                
                <p>This program was developed in response to our commitment to provide a safe, nurturing learning environment where every student can thrive academically, socially, and emotionally. Our approach combines professional counseling support with guidance services, emphasizing prevention, early intervention, and the development of empathy and conflict resolution skills.</p>
                
                <p>All reports and support requests are handled by our trained guidance counselors in partnership with our student organizations, ensuring that students receive holistic support that addresses their emotional and psychological needs.</p>
                
                <p>For questions about this program or to provide feedback, please contact our Guidance Office at <a href="tel:09061007363" style="color: var(--primary); text-decoration: underline;">09061007363</a> or email icsnaic@yahoo.com.</p>
            </div>
        </section>
    </div>
    
    <!-- Footer -->
    <footer>
        <div class="footer-content">
            <div class="footer-section">
                <h3>Immaculate Conception School of Naic Inc.</h3>
                <p>Latoria, Naic, Cavite</p>
                <p>Phone: <a href="tel:09061007363" style="color: white; text-decoration: underline;">09061007363</a></p>
                <p>Email: icsnaic@yahoo.com</p>
            </div>
            
            <div class="footer-section">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="#home">Home</a></li>
                    <li><a href="#share">Share Experience</a></li>
                    <li><a href="#counseling">Request Support</a></li>
                    <li><a href="#resources">Resources</a></li>
                </ul>
            </div>
            
            <div class="footer-section">
                <h3>Emergency Contacts</h3>
                <ul>
                    <li>School Administration: <a href="tel:09061007363" style="color: white; text-decoration: underline;">09061007363</a></li>
                    <li>Guidance Office: <a href="tel:09061007363" style="color: white; text-decoration: underline;">09061007363</a></li>
                    <li>Email: icsnaic@yahoo.com</li>
                    <li>Naic Police: 0998 967 3371 / 0998 598 5621</li>
                </ul>
            </div>
        </div>
        
        <div class="copyright">
            <p>&copy; 2025 Immaculate Conception School of Naic Inc. All rights reserved.</p>
            <p>Safe Haven Anti-Bullying Initiative</p>
        </div>
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/welcome/welcome.js') }}"></script>
</body>
</html>
