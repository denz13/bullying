<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Safe Haven | Immaculate Conception School of Naic - Anti-Bullying Initiative</title>
    <link rel="icon" type="image/png" href="{{ asset('image/logo.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('image/logo.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #1a4b84;
            --secondary: #4CAF50;
            --accent: #2E7D32;
            --light: #F5F7FA;
            --dark: #263238;
            --success: #4CAF50;
            --crisis: #F44336;
            --text: #212121;
            --gray: #6B7280;
            --border: #E5E7EB;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #F0F9FF;
            color: var(--text);
            line-height: 1.6;
        }
        
        /* Header Styles */
        header {
            background: var(--dark);
            padding: 1.5rem 0;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        
        .header-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .school-brand {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .school-logo {
            width: 80px;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            overflow: hidden;
            position: relative;
        }
        
        .school-logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            padding: 4px;
        }
        
        .school-info h1 {
            font-size: 1.25rem;
            font-weight: 600;
            color: white;
            margin-bottom: 0.25rem;
        }
        
        .school-info p {
            font-size: 0.875rem;
            color: rgba(255, 255, 255, 0.8);
        }
        
        .header-cta {
            background-color: var(--secondary);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .header-cta:hover {
            background-color: var(--accent);
            transform: translateY(-2px);
        }
        
        /* Mobile Menu Toggle */
        .mobile-menu-toggle {
            display: none;
            background: transparent;
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            padding: 0.5rem;
            align-items: center;
            justify-content: center;
        }
        
        .mobile-menu-toggle i {
            font-size: 1.5rem;
        }
        
        /* Navigation */
        nav {
            background-color: var(--dark);
            border-top: 3px solid #B8860B;
            border-bottom: 3px solid #B8860B;
            padding: 0;
            position: sticky;
            top: 90px;
            z-index: 999;
        }
        
        nav ul {
            display: flex;
            justify-content: center;
            list-style: none;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }
        
        nav li {
            margin: 0;
        }
        
        nav a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            padding: 1rem 1.5rem;
            display: block;
            transition: all 0.3s;
            font-weight: 500;
            border-bottom: 3px solid transparent;
        }
        
        nav a:hover, nav a.active {
            color: var(--secondary);
            border-bottom-color: var(--secondary);
        }
        
        /* Mobile Navigation */
        .mobile-nav {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            background: rgba(0, 0, 0, 0.95);
            z-index: 10000;
            overflow-y: auto;
            transform: translateX(-100%);
            transition: transform 0.3s ease-in-out;
        }
        
        .mobile-nav.active {
            transform: translateX(0);
        }
        
        .mobile-nav-header {
            background: var(--dark);
            padding: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 3px solid #B8860B;
        }
        
        .mobile-nav-header h3 {
            color: white;
            font-size: 1.125rem;
            font-weight: 600;
        }
        
        .mobile-nav-close {
            background: transparent;
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            padding: 0.5rem;
        }
        
        .mobile-nav-menu {
            padding: 2rem 1rem;
        }
        
        .mobile-nav-menu a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 1rem;
            margin-bottom: 0.5rem;
            border-radius: 8px;
            transition: all 0.3s;
            font-weight: 500;
        }
        
        .mobile-nav-menu a:hover,
        .mobile-nav-menu a.active {
            background: rgba(76, 175, 80, 0.2);
            color: var(--secondary);
        }
        
        /* Hero Section */
        .hero-section {
            position: relative;
            min-height: calc(100vh - 150px);
            overflow: hidden;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        
        .hero-carousel {
            position: relative;
            width: 100%;
            height: 100%;
            min-height: calc(100vh - 150px);
        }
        
        .hero-slide {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            min-height: calc(100vh - 150px);
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            opacity: 0;
            transition: opacity 1s ease-in-out;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .hero-slide.active {
            opacity: 1;
            z-index: 1;
        }
        
        .hero-slide::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(240, 249, 255, 0.85) 0%, rgba(224, 242, 254, 0.85) 100%);
            z-index: 1;
        }
        
        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 1200px;
            margin: 0 auto;
            padding: 6rem 2rem;
            text-align: center;
        }
        
        .carousel-indicators {
            position: absolute;
            bottom: 2rem;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 0.75rem;
            z-index: 3;
        }
        
        .carousel-indicator {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.5);
            border: 2px solid white;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .carousel-indicator.active {
            background: var(--secondary);
            border-color: var(--secondary);
            width: 32px;
            border-radius: 6px;
        }
        
        .hero-badge {
            display: inline-block;
            background-color: var(--secondary);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.875rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }
        
        .hero-content h1 {
            font-size: 3.5rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 1rem;
            line-height: 1.2;
        }
        
        .hero-content h1 .highlight {
            color: var(--secondary);
        }
        
        .hero-content p {
            font-size: 1.25rem;
            color: var(--gray);
            max-width: 700px;
            margin: 0 auto 2.5rem;
        }
        
        .hero-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 1rem 2rem;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
            font-size: 1rem;
        }
        
        .btn-primary {
            background-color: var(--secondary);
            color: white;
        }
        
        .btn-primary:hover {
            background-color: var(--accent);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(76, 175, 80, 0.3);
        }
        
        .btn-secondary {
            background-color: white;
            color: var(--dark);
            border: 2px solid var(--border);
        }
        
        .btn-secondary:hover {
            border-color: var(--secondary);
            color: var(--secondary);
        }
        
        /* Container */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 4rem 2rem;
        }
        
        /* Section Titles */
        .section-title {
            text-align: center;
            margin-bottom: 3rem;
        }
        
        .section-title h2 {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 1rem;
        }
        
        .section-title p {
            font-size: 1.125rem;
            color: var(--gray);
            max-width: 600px;
            margin: 0 auto;
        }
        
        /* Features Grid */
        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-bottom: 4rem;
            justify-items: center;
        }
        
        #support-section {
            text-align: center;
        }
        
        #support-section .features {
            max-width: 1000px;
            margin-left: auto;
            margin-right: auto;
        }
        
        #support-section .prayer-section {
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }
        
        #share-section {
            text-align: center;
        }
        
        #share-section .form-container {
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }
        
        #share-section .form-intro,
        #share-section .confidentiality-notice {
            text-align: left;
        }
        
        #share-section .form-group {
            text-align: left;
        }
        
        #share-section .checkbox-group {
            text-align: left;
        }
        
        #share-section .btn {
            margin: 0 auto;
        }
        
        #counseling-section {
            text-align: center;
        }
        
        #counseling-section .form-container {
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }
        
        #counseling-section .form-intro {
            text-align: left;
        }
        
        #counseling-section .form-group {
            text-align: left;
        }
        
        #counseling-section .btn {
            margin: 0 auto;
        }
        
        #resources-section {
            text-align: center;
        }
        
        #resources-section .resources {
            max-width: 1200px;
            margin-left: auto;
            margin-right: auto;
            justify-items: center;
        }
        
        #resources-section .prayer-section {
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }
        
        #about-section {
            text-align: center;
        }
        
        #about-section .form-container {
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
            text-align: left;
        }
        
        .feature-card {
            background: white;
            padding: 2.5rem;
            border-radius: 16px;
            border: 1px solid var(--border);
            transition: all 0.3s;
            text-align: center;
        }
        
        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 24px rgba(0,0,0,0.1);
            border-color: var(--secondary);
        }
        
        .feature-icon {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, #E8F5E9, #C8E6C9);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2rem;
            color: var(--secondary);
        }
        
        .feature-card h3 {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 1rem;
        }
        
        .feature-card p {
            color: var(--gray);
            line-height: 1.7;
        }
        
        /* Form Container */
        .form-container {
            background: white;
            padding: 3rem;
            border-radius: 16px;
            border: 1px solid var(--border);
            margin-bottom: 3rem;
        }
        
        .form-intro {
            margin-bottom: 2rem;
            padding-bottom: 2rem;
            border-bottom: 1px solid var(--border);
        }
        
        .form-intro p {
            font-size: 1.125rem;
            color: var(--gray);
            line-height: 1.7;
        }
        
        .confidentiality-notice {
            background: #F0F9FF;
            padding: 1.5rem;
            border-radius: 12px;
            margin-bottom: 2rem;
            border-left: 4px solid var(--primary);
        }
        
        .confidentiality-notice h4 {
            color: var(--primary);
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 600;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--dark);
            font-size: 0.875rem;
        }
        
        input, textarea, select {
            width: 100%;
            padding: 0.875rem 1rem;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s;
            font-family: inherit;
        }
        
        input:focus, textarea:focus, select:focus {
            outline: none;
            border-color: var(--secondary);
            box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.1);
        }
        
        textarea {
            min-height: 120px;
            resize: vertical;
        }
        
        .checkbox-group {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
        }
        
        .checkbox-group input[type="checkbox"] {
            width: auto;
            margin-top: 0.25rem;
        }
        
        .checkbox-group label {
            margin: 0;
            font-weight: 400;
        }
        
        /* Resources Grid */
        .resources {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }
        
        .resource-card {
            background: white;
            padding: 2rem;
            border-radius: 16px;
            border: 1px solid var(--border);
            transition: all 0.3s;
        }
        
        .resource-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
        }
        
        .resource-card h3 {
            color: var(--dark);
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 1.25rem;
        }
        
        .resource-card ul {
            list-style: none;
        }
        
        .resource-card li {
            margin-bottom: 0.75rem;
            color: var(--gray);
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
        }
        
        /* Emergency Banner */
        .emergency-banner {
            background: linear-gradient(135deg, var(--crisis), #E53935);
            color: white;
            padding: 2rem;
            border-radius: 16px;
            text-align: center;
            margin: 2rem 0;
        }
        
        .emergency-banner h3 {
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            font-size: 1.5rem;
        }
        
        /* Prayer Section */
        .prayer-section {
            background: linear-gradient(135deg, #F0F9FF, #E0F2FE);
            padding: 3rem;
            border-radius: 16px;
            text-align: center;
            margin: 3rem 0;
        }
        
        .prayer-section h3 {
            color: var(--primary);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            font-size: 1.5rem;
        }
        
        .prayer-text {
            font-style: italic;
            line-height: 1.8;
            max-width: 800px;
            margin: 0 auto;
            color: var(--dark);
            font-size: 1.125rem;
        }
        
        /* Footer */
        footer {
            background: var(--dark);
            color: white;
            padding: 2rem 2rem 1.5rem;
            margin-top: 0;
            border-top: 3px solid #8B6914;
            position: relative;
            z-index: 1;
        }
        
        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 2rem;
            margin-bottom: 1.5rem;
        }
        
        .footer-section h3 {
            margin-bottom: 0.875rem;
            font-size: 1rem;
            font-weight: 600;
            color: white;
        }
        
        .footer-section p {
            margin-bottom: 0.375rem;
            opacity: 0.9;
            line-height: 1.5;
            font-size: 0.875rem;
        }
        
        .footer-section ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .footer-section li {
            margin-bottom: 0.5rem;
            opacity: 0.9;
            line-height: 1.5;
            font-size: 0.875rem;
        }
        
        .footer-section a {
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .footer-section a:hover {
            color: var(--secondary);
        }
        
        .social-media {
            display: flex;
            gap: 0.75rem;
            margin-top: 0.75rem;
        }
        
        .social-media a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            color: white;
            transition: all 0.3s;
        }
        
        .social-media a:hover {
            background: var(--secondary);
            transform: translateY(-2px);
        }
        
        .copyright {
            text-align: center;
            padding-top: 1.5rem;
            margin-top: 1.5rem;
            border-top: 1px solid rgba(255,255,255,0.15);
            opacity: 0.8;
        }
        
        .copyright p {
            margin-bottom: 0.25rem;
            font-size: 0.8125rem;
        }
        
        
        /* Confirmation */
        .confirmation {
            display: none;
            background: linear-gradient(135deg, var(--success), #43A047);
            color: white;
            padding: 2rem;
            border-radius: 16px;
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .confirmation.show {
            display: block;
        }
        
        .confirmation h3 {
            margin-bottom: 1rem;
            font-size: 1.5rem;
        }
        
        /* Section Visibility */
        .content-section {
            display: none !important;
            margin: 0;
            padding: 0;
        }
        
        .content-section.active {
            display: block !important;
        }
        
        .content-section[style*="display: block"] {
            display: block !important;
        }
        
        #home {
            display: block;
        }
        
        #home.hidden {
            display: none !important;
        }
        
        /* Responsive */
        @media (max-width: 1024px) {
            .header-content {
                padding: 0 1.5rem;
            }
            
            .school-info h1 {
                font-size: 1.125rem;
            }
            
            nav {
                top: 85px;
            }
            
            nav ul {
                padding: 0 1.5rem 1rem;
            }
            
            .hero-content {
                padding: 4rem 1.5rem;
            }
            
            .hero-content h1 {
                font-size: 2.75rem;
            }
        }
        
        @media (max-width: 768px) {
            header {
                padding: 1rem 0;
            }
            
            .header-content {
                flex-direction: row;
                justify-content: space-between;
                padding: 0 1rem;
                gap: 0.5rem;
            }
            
            .school-brand {
                gap: 0.5rem;
                flex: 1;
                min-width: 0;
            }
            
            .school-logo {
                width: 50px;
                height: 50px;
                flex-shrink: 0;
            }
            
            .school-info {
                min-width: 0;
            }
            
            .school-info h1 {
                font-size: 0.8125rem;
                line-height: 1.2;
                overflow: hidden;
                text-overflow: ellipsis;
                display: -webkit-box;
                -webkit-line-clamp: 2;
                line-clamp: 2;
                -webkit-box-orient: vertical;
            }
            
            .mobile-menu-toggle {
                display: flex;
                flex-shrink: 0;
            }
            
            .header-cta {
                padding: 0.5rem 0.75rem;
                font-size: 0.8125rem;
                white-space: nowrap;
                flex-shrink: 0;
            }
            
            nav {
                display: none;
            }
            
            .mobile-nav {
                display: block;
            }
            
            .hero-section {
                min-height: calc(100vh - 140px);
            }
            
            .hero-carousel {
                min-height: calc(100vh - 140px);
            }
            
            .hero-slide {
                min-height: calc(100vh - 140px);
            }
            
            .hero-content {
                padding: 3rem 1rem;
            }
            
            .hero-content h1 {
                font-size: 2rem;
                line-height: 1.2;
            }
            
            .hero-content p {
                font-size: 1rem;
                margin-bottom: 1.5rem;
            }
            
            .hero-buttons {
                flex-direction: column;
                gap: 0.75rem;
            }
            
            .btn {
                width: 100%;
                justify-content: center;
            }
            
            .carousel-indicators {
                bottom: 1rem;
                gap: 0.5rem;
            }
            
            .carousel-indicator {
                width: 10px;
                height: 10px;
            }
            
            .carousel-indicator.active {
                width: 24px;
            }
            
            .content-section {
                padding: 2rem 1rem;
            }
            
            .content-section .container {
                padding: 0;
            }
            
            .section-title {
                margin-bottom: 2rem;
            }
            
            .section-title h2 {
                font-size: 1.75rem;
            }
            
            .section-title p {
                font-size: 0.9375rem;
            }
            
            .feature-grid,
            .features {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }
            
            #support-section .features {
                max-width: 100%;
            }
            
            .feature-card {
                padding: 1.5rem;
            }
            
            .form-container {
                padding: 1.5rem 1rem;
            }
            
            #share-section .form-container,
            #counseling-section .form-container,
            #about-section .form-container {
                max-width: 100%;
            }
            
            .form-group label {
                font-size: 0.9375rem;
            }
            
            .form-group input,
            .form-group textarea,
            .form-group select {
                font-size: 0.9375rem;
                padding: 0.75rem;
            }
            
            .resource-grid,
            .resources {
                grid-template-columns: 1fr;
                gap: 1rem;
            }
            
            #resources-section .resources {
                max-width: 100%;
            }
            
            .resource-card {
                padding: 1.25rem;
            }
            
            .prayer-section {
                padding: 2rem 1.5rem;
                margin: 2rem 0;
            }
            
            #support-section .prayer-section,
            #resources-section .prayer-section {
                max-width: 100%;
            }
            
            .footer-content {
                grid-template-columns: 1fr;
                gap: 2rem;
            }
            
            footer {
                padding: 2rem 1rem 1rem;
            }
            
            .footer-section h3 {
                font-size: 1rem;
            }
            
            .footer-section p,
            .footer-section li {
                font-size: 0.875rem;
            }
        }
        
        @media (max-width: 480px) {
            .header-content {
                padding: 0 0.75rem;
            }
            
            .school-logo {
                width: 50px;
                height: 50px;
            }
            
            .school-info h1 {
                font-size: 0.8125rem;
            }
            
            .header-cta {
                padding: 0.5rem 0.75rem;
                font-size: 0.8125rem;
            }
            
            
            .hero-section {
                min-height: calc(100vh - 130px);
            }
            
            .hero-carousel {
                min-height: calc(100vh - 130px);
            }
            
            .hero-slide {
                min-height: calc(100vh - 130px);
            }
            
            .hero-content {
                padding: 2rem 0.75rem;
            }
            
            .hero-content h1 {
                font-size: 1.75rem;
            }
            
            .hero-content p {
                font-size: 0.9375rem;
            }
            
            .section-title h2 {
                font-size: 1.5rem;
            }
            
            .content-section {
                padding: 1.5rem 0.75rem;
            }
            
            .content-section .container {
                padding: 0;
            }
            
            .form-container {
                padding: 1.25rem 0.75rem;
            }
            
            #share-section .form-container,
            #counseling-section .form-container,
            #about-section .form-container {
                max-width: 100%;
            }
            
            .prayer-section {
                padding: 1.5rem 1rem;
            }
            
            #support-section .prayer-section,
            #resources-section .prayer-section {
                max-width: 100%;
            }
            
            .features,
            .resources {
                gap: 1rem;
            }
            
            #support-section .features,
            #resources-section .resources {
                max-width: 100%;
            }
            
            footer {
                padding: 1.5rem 0.75rem 1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <div class="header-content">
            <button class="mobile-menu-toggle" onclick="toggleMobileNav()" aria-label="Toggle menu">
                <i class="fas fa-bars"></i>
            </button>
            <div class="school-brand">
                <div class="school-logo">
                    <img src="{{ asset('image/logo.png') }}" alt="Logo">
                </div>
                <div class="school-info">
                    <h1>Immaculate Conception School of Naic INC.</h1>
                </div>
            </div>
            <a href="{{ route('login') }}" class="header-cta">
                Login <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </header>
    
    <!-- Navigation -->
    <nav>
        <ul>
            <li><a href="#home" class="active">Home</a></li>
            <li><a href="#support">Our Support Approach</a></li>
            <li><a href="#share">Share Experience</a></li>
            <li><a href="#counseling">Request Counseling</a></li>
            <li><a href="#resources">Resources</a></li>
            <li><a href="#about">About</a></li>
        </ul>
    </nav>
    
    <!-- Mobile Navigation -->
    <div class="mobile-nav" id="mobileNav">
        <div class="mobile-nav-header">
            <h3>Menu</h3>
            <button class="mobile-nav-close" onclick="toggleMobileNav()" aria-label="Close menu">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="mobile-nav-menu">
            <a href="#home" onclick="event.preventDefault(); toggleMobileNav(); showSection('home'); window.location.hash = 'home';">Home</a>
            <a href="#support" onclick="event.preventDefault(); toggleMobileNav(); showSection('support'); window.location.hash = 'support';">Our Support Approach</a>
            <a href="#share" onclick="event.preventDefault(); toggleMobileNav(); showSection('share'); window.location.hash = 'share';">Share Experience</a>
            <a href="#counseling" onclick="event.preventDefault(); toggleMobileNav(); showSection('counseling'); window.location.hash = 'counseling';">Request Counseling</a>
            <a href="#resources" onclick="event.preventDefault(); toggleMobileNav(); showSection('resources'); window.location.hash = 'resources';">Resources</a>
            <a href="#about" onclick="event.preventDefault(); toggleMobileNav(); showSection('about'); window.location.hash = 'about';">About</a>
        </div>
    </div>
    
    <!-- Hero Section -->
    <section id="home" class="hero-section">
        <div class="hero-carousel">
            @if(isset($images) && count($images) > 0)
                @foreach($images as $index => $image)
                    <div class="hero-slide {{ $index === 0 ? 'active' : '' }}" style="background-image: url('{{ $image }}');">
                        <div class="hero-content">
                            @if($index === 0)
                                <h1>Lessons and insights<br><span class="highlight">from years of support</span></h1>
                                <p>Creating a community of respect and compassion. Every student deserves to learn in a safe, nurturing environment free from fear and intimidation.</p>
                            @elseif($index === 1)
                                <h1>Building a Safe Learning Environment<br><span class="highlight">for Every Student</span></h1>
                                <p>We are committed to providing comprehensive support and guidance to ensure every student feels valued, respected, and safe in our school community.</p>
                            @else
                                <h1>Supporting Student Well-being<br><span class="highlight">Together We Grow</span></h1>
                                <p>Our guidance office is here to help students navigate challenges, build resilience, and achieve their full potential in a supportive environment.</p>
                            @endif
                        </div>
                    </div>
                @endforeach
                <div class="carousel-indicators">
                    @foreach($images as $index => $image)
                        <span class="carousel-indicator {{ $index === 0 ? 'active' : '' }}" data-slide="{{ $index }}"></span>
                    @endforeach
                </div>
            @else
                <!-- Fallback if no images -->
                <div class="hero-slide active" style="background-image: url('https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=1920&q=80');">
                    <div class="hero-content">
                        <h1>Lessons and insights<br><span class="highlight">from years of support</span></h1>
                        <p>Creating a community of respect and compassion. Every student deserves to learn in a safe, nurturing environment free from fear and intimidation.</p>
                    </div>
                </div>
                <div class="carousel-indicators">
                    <span class="carousel-indicator active" data-slide="0"></span>
                </div>
            @endif
        </div>
    </section>
    
    <!-- Our Support Approach Section -->
    <div class="content-section" id="support-section">
        <div class="container">
            <section id="support">
                <div class="section-title">
                    <h2>Our Support Approach</h2>
                    <p>We provide comprehensive support rooted in Catholic values of compassion, dignity, and respect</p>
                </div>
                
                <div class="features">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h3>Confidential & Safe</h3>
                        <p>All reports are handled with strict confidentiality by our trained guidance counselors in accordance with our Catholic values.</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-heart"></i>
                        </div>
                        <h3>Compassionate Response</h3>
                        <p>We respond with Christ's compassion, focusing on healing, forgiveness, and restoration for all involved.</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-hands"></i>
                        </div>
                        <h3>Pastoral Support</h3>
                        <p>Our school chaplain and campus ministry team provide spiritual guidance and emotional support.</p>
                    </div>
                </div>
                
                <!-- Prayer Section -->
                <div class="prayer-section">
                    <h3><i class="fas fa-pray"></i> A Prayer for Healing</h3>
                    <p class="prayer-text">"Loving God, we ask for your protection over all students. Grant wisdom to those who lead, compassion to those who teach, and courage to those who suffer. Help us build a school community where every person is valued, respected, and safe. Amen."</p>
                </div>
            </section>
        </div>
    </div>
    
    <!-- Share Experience Section -->
    <div class="content-section" id="share-section">
        <div class="container">
            <section id="share">
                <div class="section-title">
                    <h2>Share Your Experience</h2>
                    <p>Your voice matters. By speaking up, you help make our school safer for everyone.</p>
                </div>
                
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
                        <label for="experience-type">Type of Experience <span style="color: var(--crisis);">*</span></label>
                        <select id="experience-type" name="type_experience" required>
                            <option value="">Please select one</option>
                            <option value="Verbal Bullying (name-calling, teasing)">Verbal Bullying (name-calling, teasing)</option>
                            <option value="Physical Bullying (hitting, pushing)">Physical Bullying (hitting, pushing)</option>
                            <option value="Social Bullying (exclusion, rumors)">Social Bullying (exclusion, rumors)</option>
                            <option value="Cyberbullying (online harassment)">Cyberbullying (online harassment)</option>
                            <option value="Religious/Cultural Harassment">Religious/Cultural Harassment</option>
                            <option value="Other Form of Bullying">Other Form of Bullying</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="experience-details">Please describe what happened <span style="color: var(--crisis);">*</span></label>
                        <textarea id="experience-details" name="content" placeholder="Include details about the incident, when and where it occurred, who was involved, and how it made you feel..." required></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="support-needed">What kind of support would be most helpful to you?</label>
                        <textarea id="support-needed" name="type_of_support" placeholder="Are you looking for counseling, mediation, spiritual guidance, or other forms of support?"></textarea>
                    </div>
                    
                    <div class="checkbox-group">
                        <input type="checkbox" id="anonymous" name="is_anonymously" value="1" checked>
                        <label for="anonymous">Submit anonymously (your identity will not be recorded)</label>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane"></i> Share Your Experience
                    </button>
                </form>
                
                <div id="experience-confirmation" class="confirmation">
                    <h3>Thank You for Your Courage</h3>
                    <p>Your experience has been recorded and will be reviewed by our guidance team. It takes strength to speak up, and by doing so, you're helping create a safer school community.</p>
                    <p>If you provided contact information and requested follow-up, a counselor will reach out to you within 24 hours.</p>
                </div>
                </div>
            </section>
        </div>
    </div>
    
    <!-- Counseling Section -->
    <div class="content-section" id="counseling-section">
        <div class="container">
            <section id="counseling">
                <div class="section-title">
                    <h2>Request Counseling Support</h2>
                    <p>Our team of trained counselors and school chaplain are here to provide emotional, psychological, and spiritual support.</p>
                </div>
                
                <div class="form-container">
                    <div class="form-intro">
                        <p>Our team of trained counselors and our school chaplain are here to provide emotional, psychological, and spiritual support. Please fill out this form to request assistance.</p>
                    </div>
                    
                    <form id="counseling-form" method="POST" action="{{ route('request-counseling.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="name">Your Name (optional)</label>
                            <input type="text" id="name" name="fullname" placeholder="If you prefer to remain anonymous, leave this blank">
                        </div>
                        
                        <div class="form-group">
                            <label for="grade-section">Grade & Section</label>
                            <input type="text" id="grade-section" name="grade_section" placeholder="e.g., Grade 7 - St. Augustine">
                        </div>
                        
                        <div class="form-group">
                            <label for="contact">How can we contact you? (optional)</label>
                            <input type="text" id="contact" name="contact_details" placeholder="Email, phone number, or other preferred contact method">
                        </div>
                        
                        <div class="form-group">
                            <label for="urgency">Urgency Level <span style="color: var(--crisis);">*</span></label>
                            <select id="urgency" name="urgent_level" required>
                                <option value="">Please select one</option>
                                <option value="I'd like to talk when convenient">I'd like to talk when convenient</option>
                                <option value="I'd like to connect in the next few days">I'd like to connect in the next few days</option>
                                <option value="I need to speak with someone as soon as possible">I need to speak with someone as soon as possible</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="counseling-details">What would you like to discuss with a counselor? <span style="color: var(--crisis);">*</span></label>
                            <textarea id="counseling-details" name="content" placeholder="Please share any information that would help us understand how to best support you..." required></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="preferred-method">Preferred Support Method</label>
                            <select id="preferred-method" name="support_method">
                                <option value="">No preference</option>
                                <option value="in-person">In-person meeting</option>
                                <option value="chaplain">Meeting with school chaplain</option>
                                <option value="phone">Phone call</option>
                                <option value="group">Group counseling session</option>
                            </select>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-hands-helping"></i> Request Counseling
                        </button>
                    </form>
                </div>
            </section>
        </div>
    </div>
    
    <!-- Resources Section -->
    <div class="content-section" id="resources-section">
        <div class="container">
            <section id="resources">
                <div class="section-title">
                    <h2>Resources & Support</h2>
                    <p>Access helpful resources and support services available to students and families</p>
                </div>
                
                <div class="resources">
                <div class="resource-card">
                    <h3><i class="fas fa-phone-alt"></i> Immediate Help</h3>
                    <ul>
                        <li>School Guidance Office: (046) 123-4567 ext. 102</li>
                        <li>School Administration: (046) 123-4567 ext. 101</li>
                        <li>School Chaplain: (046) 123-4567 ext. 103</li>
                        <li>National Crisis Hotline: 0917-899-8727</li>
                    </ul>
                </div>
                
                <div class="resource-card">
                    <h3><i class="fas fa-hands-helping"></i> Counseling Services</h3>
                    <ul>
                        <li>Individual counseling sessions</li>
                        <li>Peer mediation programs</li>
                        <li>Spiritual guidance with chaplain</li>
                        <li>Group therapy sessions</li>
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
                
                <div class="prayer-section">
                    <h3><i class="fas fa-cross"></i> Spiritual Resources</h3>
                    <p class="prayer-text">"Do not be overcome by evil, but overcome evil with good." - Romans 12:21</p>
                    <p style="margin-top: 1rem; font-style: normal;">Visit our chapel for quiet reflection or speak with our chaplain for spiritual guidance and prayer support.</p>
                </div>
            </section>
        </div>
    </div>
    
    <!-- About Section -->
    <div class="content-section" id="about-section">
        <div class="container">
            <section id="about">
                <div class="section-title">
                    <h2>About Safe Haven</h2>
                    <p>Our comprehensive anti-bullying initiative rooted in Catholic values</p>
                </div>
                
                <div class="form-container">
                    <p>Safe Haven is Immaculate Conception School of Naic's comprehensive anti-bullying initiative, rooted in our Catholic values of compassion, dignity, and respect for all persons as children of God.</p>
                    
                    <p style="margin-top: 1.5rem;">This program was developed in response to our commitment to provide a safe, nurturing learning environment where every student can thrive academically, socially, and spiritually. Our approach combines professional counseling support with pastoral care, emphasizing prevention, early intervention, and the development of empathy and conflict resolution skills.</p>
                    
                    <p style="margin-top: 1.5rem;">All reports and counseling requests are handled by our trained guidance counselors in partnership with our school chaplain, ensuring that students receive holistic support that addresses their emotional, psychological, and spiritual needs.</p>
                    
                    <p style="margin-top: 1.5rem;">For questions about this program or to provide feedback, please contact our Guidance Office at (046) 123-4567 ext. 102.</p>
                </div>
            </section>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="footer-content">
            <div class="footer-section">
                <h3>Immaculate Conception School of Naic INC.</h3>
                <p>M. Evangelista Street, Naic, Cavite</p>
                <p>Phone: (046) 123-4567</p>
                <p>Email: info@icsnaic.edu.ph</p>
            </div>
            
            <div class="footer-section">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="#home">Home</a></li>
                    <li><a href="#share">Share Experience</a></li>
                    <li><a href="#counseling">Request Counseling</a></li>
                    <li><a href="#resources">Resources</a></li>
                </ul>
            </div>
            
            <div class="footer-section">
                <h3>Emergency Contacts</h3>
                <ul>
                    <li>School Administration: ext. 101</li>
                    <li>Guidance Office: ext. 102</li>
                    <li>School Chaplain: ext. 103</li>
                    <li>Naic Police: 911 or (046) 412-3456</li>
                </ul>
            </div>
            
            <div class="footer-section">
                <h3>Follow Us</h3>
                <p style="margin-bottom: 0.75rem; opacity: 0.9; font-size: 0.875rem;">Connect with us on social media</p>
                <div class="social-media">
                    <a href="https://www.facebook.com/profile.php?id=100057504487757" title="Facebook" aria-label="Facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" title="Twitter" aria-label="Twitter">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" title="Instagram" aria-label="Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" title="YouTube" aria-label="YouTube">
                        <i class="fab fa-youtube"></i>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="copyright">
            <p>&copy; 2023 Immaculate Conception School of Naic. All rights reserved.</p>
            <p>Safe Haven Anti-Bullying Initiative</p>
        </div>
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Make toggleMobileNav available immediately (before defer script loads)
        function toggleMobileNav() {
            const mobileNav = document.getElementById('mobileNav');
            if (mobileNav) {
                mobileNav.classList.toggle('active');
                document.body.style.overflow = mobileNav.classList.contains('active') ? 'hidden' : '';
            }
        }
        
        // Make showSection available immediately (before defer script loads)
        function showSection(sectionId) {
            // Hide hero section
            const heroSection = document.getElementById('home');
            if (heroSection) {
                if (sectionId === 'home') {
                    heroSection.style.display = 'block';
                    heroSection.classList.remove('hidden');
                } else {
                    heroSection.style.display = 'none';
                    heroSection.classList.add('hidden');
                }
            }
            
            // Hide all content sections first
            document.querySelectorAll('.content-section').forEach(section => {
                section.style.setProperty('display', 'none', 'important');
                section.classList.remove('active');
            });
            
            // Show selected section
            if (sectionId === 'home') {
                // Scroll to top for home
                window.scrollTo({ top: 0, behavior: 'smooth' });
            } else {
                const targetSection = document.getElementById(sectionId + '-section');
                if (targetSection) {
                    // Use both inline style and class to ensure visibility
                    targetSection.style.setProperty('display', 'block', 'important');
                    targetSection.classList.add('active');
                    // Force a reflow to ensure display change takes effect
                    void targetSection.offsetHeight;
                    setTimeout(() => {
                        targetSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }, 100);
                }
            }
            
            // Update active nav link (desktop)
            document.querySelectorAll('nav a').forEach(link => {
                link.classList.remove('active');
            });
            const activeLink = document.querySelector(`nav a[href="#${sectionId}"]`);
            if (activeLink) {
                activeLink.classList.add('active');
            }
            
            // Update active nav link (mobile)
            document.querySelectorAll('.mobile-nav-menu a').forEach(link => {
                link.classList.remove('active');
            });
            const activeMobileLink = document.querySelector(`.mobile-nav-menu a[href="#${sectionId}"]`);
            if (activeMobileLink) {
                activeMobileLink.classList.add('active');
            }
        }
        
        // Set up desktop navigation click handlers immediately
        function setupNavHandlers() {
            document.querySelectorAll('nav a[href^="#"]').forEach((anchor) => {
                anchor.addEventListener('click', function(event) {
                    event.preventDefault();
                    const targetId = this.getAttribute('href').substring(1);
                    showSection(targetId);
                    // Update URL hash
                    window.location.hash = targetId;
                });
            });
        }
        
        // Set up handlers when DOM is ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', setupNavHandlers);
        } else {
            // DOM already loaded, set up immediately
            setupNavHandlers();
        }
    </script>
    <script src="{{ asset('js/welcome/welcome.js') }}" defer></script>
</body>
</html>
