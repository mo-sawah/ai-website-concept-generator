<?php
// templates/generator-form.php
?>
<div class="aiwcg-container">
    <style>
        .aiwcg-container {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(135deg, #1e1b4b 0%, #312e81 25%, #1e40af 50%, #7c3aed 75%, #1e1b4b 100%);
            background-size: 400% 400%;
            animation: gradientShift 8s ease infinite;
            color: white;
            min-height: 100vh;
            padding: 2rem 1rem;
        }
        
        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        .aiwcg-glass {
            background: rgba(25, 25, 30, 0.45);
            backdrop-filter: blur(18px) saturate(120%);
            border: 1px solid rgba(255, 255, 255, 0.09);
            box-shadow: 0 12px 48px rgba(0, 0, 0, 0.35), 0 2px 12px rgba(0, 0, 0, 0.2), inset 0 1px 0 rgba(255, 255, 255, 0.04);
            border-radius: 1rem;
            padding: 2rem;
            margin-bottom: 1.5rem;
        }
        
        .aiwcg-input, .aiwcg-select, .aiwcg-textarea {
            background-color: rgba(55, 65, 81, 0.5);
            border: 1px solid #4b5563;
            border-radius: 0.75rem;
            padding: 0.75rem 1rem;
            color: white;
            width: 100%;
            transition: border-color 0.2s ease-in-out;
        }
        
        .aiwcg-input:focus, .aiwcg-select:focus, .aiwcg-textarea:focus {
            outline: none;
            border-color: #8b5cf6;
        }
        
        .aiwcg-grid {
            display: grid;
            gap: 1.5rem;
        }
        
        .aiwcg-grid-2 {
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        }
        
        .aiwcg-grid-3 {
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        }
        
        .aiwcg-button {
            background: linear-gradient(to right, #7c3aed, #3b82f6);
            color: white;
            padding: 1rem 2rem;
            border-radius: 0.75rem;
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 1.1rem;
        }
        
        .aiwcg-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
        }
        
        .aiwcg-option-button {
            padding: 0.75rem;
            border: 2px solid #4b5563;
            background: rgba(55, 65, 81, 0.3);
            color: #d1d5db;
            border-radius: 0.5rem;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: left;
            width: 100%;
        }
        
        .aiwcg-option-button:hover {
            border-color: #8b5cf6;
        }
        
        .aiwcg-option-button.selected {
            border-color: #8b5cf6;
            background-color: rgba(139, 92, 246, 0.2);
            color: white;
        }
        
        .aiwcg-spinner {
            border: 4px solid #374151;
            border-top: 4px solid #8b5cf6;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 0 auto;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .aiwcg-progress-step {
            padding: 1rem;
            background: rgba(55, 65, 81, 0.3);
            border-radius: 0.5rem;
            margin-bottom: 0.5rem;
            transition: all 0.5s ease;
        }
        
        .aiwcg-progress-step.active {
            background-color: rgba(139, 92, 246, 0.2);
            color: #c4b5fd;
            border: 1px solid rgba(139, 92, 246, 0.3);
        }
        
        .aiwcg-hidden {
            display: none;
        }
        
        .aiwcg-wireframe-section {
            border-radius: 0.5rem;
            margin-bottom: 0.25rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 500;
            font-size: 0.875rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .aiwcg-wireframe-section:hover {
            transform: scale(1.02);
        }
        
        .aiwcg-color-swatch {
            width: 3rem;
            height: 3rem;
            border-radius: 0.75rem;
            border: 2px solid #4b5563;
            margin: 0 auto 0.5rem;
        }
        
        .aiwcg-feature-badge {
            padding: 1rem;
            border-radius: 0.5rem;
            border: 1px solid;
            margin-bottom: 1rem;
        }
        
        .aiwcg-feature-badge.essential {
            background: rgba(34, 197, 94, 0.1);
            border-color: rgba(34, 197, 94, 0.3);
        }
        
        .aiwcg-feature-badge.recommended {
            background: rgba(59, 130, 246, 0.1);
            border-color: rgba(59, 130, 246, 0.3);
        }
        
        .aiwcg-feature-badge.advanced {
            background: rgba(139, 92, 246, 0.1);
            border-color: rgba(139, 92, 246, 0.3);
        }
        
        .aiwcg-metric-card {
            background: rgba(31, 41, 55, 0.5);
            padding: 1.5rem;
            border-radius: 0.75rem;
            text-align: center;
        }
        
        .aiwcg-metric-value {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 0.25rem;
        }
        
        .aiwcg-metric-label {
            font-size: 0.875rem;
            color: #9ca3af;
        }
        
        .aiwcg-section-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
        }
        
        .aiwcg-section-icon {
            width: 1.5rem;
            height: 1.5rem;
            margin-right: 0.75rem;
            color: #a855f7;
        }
        
        .aiwcg-form-label {
            display: block;
            color: #d1d5db;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }
        
        .aiwcg-validation-message {
            color: #ef4444;
            font-size: 0.875rem;
            margin-top: 1rem;
            text-align: center;
        }
        
        .aiwcg-results-header {
            text-align: center;
            margin-bottom: 3rem;
        }
        
        .aiwcg-success-icon {
            width: 4rem;
            height: 4rem;
            background: #22c55e;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
        }
    </style>

    <div class="aiwcg-content">
        <!-- Header -->
        <div style="text-align: center; margin-bottom: 3rem;">
            <h1 style="font-size: 2.5rem; font-weight: bold; margin-bottom: 1rem; display: flex; align-items: center; justify-content: center;">
                <svg class="aiwcg-section-icon" style="margin-right: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                </svg>
                AI Website Builder
            </h1>
            <p style="font-size: 1.25rem; color: #d1d5db; max-width: 800px; margin: 0 auto;">
                Describe your business and watch AI create a complete website concept with detailed wireframes, 
                color schemes, cost estimates, and technical specifications.
            </p>
        </div>

        <!-- Form Section -->
        <div id="aiwcg-form-section">
            <!-- Business Information -->
            <div class="aiwcg-glass">
                <h3 class="aiwcg-section-title">
                    <svg class="aiwcg-section-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    Business Information
                </h3>
                
                <div class="aiwcg-grid aiwcg-grid-2">
                    <div>
                        <label class="aiwcg-form-label">Business Name/Type</label>
                        <input type="text" id="aiwcg-businessType" class="aiwcg-input" placeholder="e.g., TechFlow Solutions, Local Restaurant, Law Firm" />
                    </div>
                    
                    <div>
                        <label class="aiwcg-form-label">Industry</label>
                        <select id="aiwcg-industry" class="aiwcg-select">
                            <option value="">Select Industry</option>
                            <option value="Technology & Software">Technology & Software</option>
                            <option value="Healthcare & Medical">Healthcare & Medical</option>
                            <option value="E-commerce & Retail">E-commerce & Retail</option>
                            <option value="Education & Training">Education & Training</option>
                            <option value="Finance & Banking">Finance & Banking</option>
                            <option value="Real Estate">Real Estate</option>
                            <option value="Restaurant & Food">Restaurant & Food</option>
                            <option value="Legal Services">Legal Services</option>
                            <option value="Creative Agency">Creative Agency</option>
                            <option value="Non-Profit">Non-Profit</option>
                            <option value="Fitness & Wellness">Fitness & Wellness</option>
                            <option value="Travel & Tourism">Travel & Tourism</option>
                            <option value="Automotive">Automotive</option>
                            <option value="Fashion & Beauty">Fashion & Beauty</option>
                            <option value="Construction">Construction</option>
                            <option value="Consulting">Consulting</option>
                            <option value="Manufacturing">Manufacturing</option>
                            <option value="Entertainment">Entertainment</option>
                            <option value="Photography">Photography</option>
                            <option value="Marketing & Advertising">Marketing & Advertising</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="aiwcg-form-label">Company Size</label>
                        <select id="aiwcg-companySize" class="aiwcg-select">
                            <option value="">Select Company Size</option>
                            <option value="Solo/Freelancer">Solo/Freelancer</option>
                            <option value="2-10 employees">2-10 employees</option>
                            <option value="11-50 employees">11-50 employees</option>
                            <option value="51-200 employees">51-200 employees</option>
                            <option value="200+ employees">200+ employees</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="aiwcg-form-label">Target Audience</label>
                        <input type="text" id="aiwcg-targetAudience" class="aiwcg-input" placeholder="e.g., Small businesses, Young professionals, Families" />
                    </div>
                    
                    <div>
                        <label class="aiwcg-form-label">Primary Business Goal</label>
                        <select id="aiwcg-businessGoal" class="aiwcg-select">
                            <option value="">Select Primary Goal</option>
                            <option value="Generate Leads">Generate Leads</option>
                            <option value="Sell Products Online">Sell Products Online</option>
                            <option value="Build Brand Awareness">Build Brand Awareness</option>
                            <option value="Provide Information">Provide Information</option>
                            <option value="Showcase Portfolio">Showcase Portfolio</option>
                            <option value="Accept Bookings/Appointments">Accept Bookings/Appointments</option>
                            <option value="Customer Support">Customer Support</option>
                            <option value="Community Building">Community Building</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="aiwcg-form-label">Project Budget</label>
                        <select id="aiwcg-budget" class="aiwcg-select">
                            <option value="">Select Budget Range</option>
                            <option value="$1,000 - $3,000">$1,000 - $3,000</option>
                            <option value="$3,000 - $5,000">$3,000 - $5,000</option>
                            <option value="$5,000 - $10,000">$5,000 - $10,000</option>
                            <option value="$10,000 - $20,000">$10,000 - $20,000</option>
                            <option value="$20,000 - $50,000">$20,000 - $50,000</option>
                            <option value="$50,000+">$50,000+</option>
                        </select>
                    </div>
                </div>
                
                <div style="margin-top: 1.5rem;">
                    <label class="aiwcg-form-label">Brief Description of Your Business</label>
                    <textarea id="aiwcg-businessDescription" class="aiwcg-textarea" rows="3" placeholder="Tell us about your business, what you do, and what makes you unique..."></textarea>
                </div>
            </div>

            <!-- Website Requirements -->
            <div class="aiwcg-glass">
                <h3 class="aiwcg-section-title">
                    <svg class="aiwcg-section-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    Website Requirements
                </h3>
                
                <div class="aiwcg-grid aiwcg-grid-2">
                    <div>
                        <label class="aiwcg-form-label">Timeline</label>
                        <select id="aiwcg-timeline" class="aiwcg-select">
                            <option value="">Select Timeline</option>
                            <option value="ASAP (Rush)">ASAP (Rush)</option>
                            <option value="2-4 weeks">2-4 weeks</option>
                            <option value="1-2 months">1-2 months</option>
                            <option value="2-3 months">2-3 months</option>
                            <option value="3+ months">3+ months</option>
                            <option value="Flexible">Flexible</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="aiwcg-form-label">Current Website Status</label>
                        <select id="aiwcg-currentWebsite" class="aiwcg-select">
                            <option value="">Select Current Status</option>
                            <option value="No website">No website</option>
                            <option value="Outdated website">Outdated website</option>
                            <option value="Need redesign">Need redesign</option>
                            <option value="Need improvements">Need improvements</option>
                            <option value="Starting fresh">Starting fresh</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Website Type and Design Style -->
            <div class="aiwcg-grid aiwcg-grid-2">
                <div class="aiwcg-glass">
                    <h3 class="aiwcg-section-title">
                        <svg class="aiwcg-section-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Website Type
                    </h3>
                    
                    <div class="aiwcg-grid" style="grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 0.75rem;" id="aiwcg-websiteTypes">
                        <button class="aiwcg-option-button aiwcg-website-type" data-value="Business Website">
                            <div style="font-weight: 600; margin-bottom: 0.25rem;">Business Website</div>
                            <div style="font-size: 0.75rem; color: #9ca3af;">For companies</div>
                        </button>
                        <button class="aiwcg-option-button aiwcg-website-type" data-value="E-commerce Store">
                            <div style="font-weight: 600; margin-bottom: 0.25rem;">E-commerce Store</div>
                            <div style="font-size: 0.75rem; color: #9ca3af;">Sell products online</div>
                        </button>
                        <button class="aiwcg-option-button aiwcg-website-type" data-value="Portfolio Site">
                            <div style="font-weight: 600; margin-bottom: 0.25rem;">Portfolio Site</div>
                            <div style="font-size: 0.75rem; color: #9ca3af;">For creatives</div>
                        </button>
                        <button class="aiwcg-option-button aiwcg-website-type" data-value="SaaS Platform">
                            <div style="font-weight: 600; margin-bottom: 0.25rem;">SaaS Platform</div>
                            <div style="font-size: 0.75rem; color: #9ca3af;">For SaaS startups</div>
                        </button>
                        <button class="aiwcg-option-button aiwcg-website-type" data-value="Landing Page">
                            <div style="font-weight: 600; margin-bottom: 0.25rem;">Landing Page</div>
                            <div style="font-size: 0.75rem; color: #9ca3af;">For campaigns</div>
                        </button>
                        <button class="aiwcg-option-button aiwcg-website-type" data-value="Booking/Appointment">
                            <div style="font-weight: 600; margin-bottom: 0.25rem;">Booking/Appointment</div>
                            <div style="font-size: 0.75rem; color: #9ca3af;">For services</div>
                        </button>
                    </div>
                </div>

                <div class="aiwcg-glass">
                    <h3 class="aiwcg-section-title">
                        <svg class="aiwcg-section-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM21 5a2 2 0 00-2-2h-4a2 2 0 00-2 2v12a4 4 0 004 4h4a2 2 0 002-2V5z" />
                        </svg>
                        Design Style
                    </h3>
                    
                    <div class="aiwcg-grid" style="grid-template-columns: repeat(2, 1fr); gap: 0.5rem; max-height: 300px; overflow-y: auto;" id="aiwcg-designStyles">
                        <button class="aiwcg-option-button aiwcg-design-style" data-value="Modern & Clean">Modern & Clean</button>
                        <button class="aiwcg-option-button aiwcg-design-style" data-value="Professional & Corporate">Professional & Corporate</button>
                        <button class="aiwcg-option-button aiwcg-design-style" data-value="Creative & Artistic">Creative & Artistic</button>
                        <button class="aiwcg-option-button aiwcg-design-style" data-value="Minimalist">Minimalist</button>
                        <button class="aiwcg-option-button aiwcg-design-style" data-value="Bold & Vibrant">Bold & Vibrant</button>
                        <button class="aiwcg-option-button aiwcg-design-style" data-value="Elegant & Luxury">Elegant & Luxury</button>
                        <button class="aiwcg-option-button aiwcg-design-style" data-value="Tech & Futuristic">Tech & Futuristic</button>
                        <button class="aiwcg-option-button aiwcg-design-style" data-value="Fun & Playful">Fun & Playful</button>
                    </div>
                </div>
            </div>

            <!-- Features -->
            <div class="aiwcg-glass">
                <h3 class="aiwcg-section-title">
                    <svg class="aiwcg-section-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    Core Features & Functionality
                </h3>
                
                <div class="aiwcg-grid aiwcg-grid-3">
                    <div>
                        <h4 style="font-weight: 600; margin-bottom: 1rem; color: #22c55e;">Essential Features</h4>
                        <div id="aiwcg-essentialFeatures" style="display: grid; gap: 0.5rem;">
                            <button class="aiwcg-option-button aiwcg-feature" data-value="Contact Forms">Contact Forms</button>
                            <button class="aiwcg-option-button aiwcg-feature" data-value="Mobile Responsive">Mobile Responsive</button>
                            <button class="aiwcg-option-button aiwcg-feature" data-value="SEO Optimization">SEO Optimization</button>
                            <button class="aiwcg-option-button aiwcg-feature" data-value="Social Media Integration">Social Media Integration</button>
                            <button class="aiwcg-option-button aiwcg-feature" data-value="Google Analytics">Google Analytics</button>
                        </div>
                    </div>

                    <div>
                        <h4 style="font-weight: 600; margin-bottom: 1rem; color: #3b82f6;">Business Features</h4>
                        <div id="aiwcg-businessFeatures" style="display: grid; gap: 0.5rem;">
                            <button class="aiwcg-option-button aiwcg-feature" data-value="Online Booking">Online Booking</button>
                            <button class="aiwcg-option-button aiwcg-feature" data-value="E-commerce Store">E-commerce Store</button>
                            <button class="aiwcg-option-button aiwcg-feature" data-value="Payment Gateway">Payment Gateway</button>
                            <button class="aiwcg-option-button aiwcg-feature" data-value="Customer Portal">Customer Portal</button>
                            <button class="aiwcg-option-button aiwcg-feature" data-value="CRM Integration">CRM Integration</button>
                        </div>
                    </div>

                    <div>
                        <h4 style="font-weight: 600; margin-bottom: 1rem; color: #8b5cf6;">Advanced Features</h4>
                        <div id="aiwcg-advancedFeatures" style="display: grid; gap: 0.5rem;">
                            <button class="aiwcg-option-button aiwcg-feature" data-value="Live Chat">Live Chat</button>
                            <button class="aiwcg-option-button aiwcg-feature" data-value="AI Chatbot">AI Chatbot</button>
                            <button class="aiwcg-option-button aiwcg-feature" data-value="Blog System">Blog System</button>
                            <button class="aiwcg-option-button aiwcg-feature" data-value="User Registration">User Registration</button>
                            <button class="aiwcg-option-button aiwcg-feature" data-value="API Integration">API Integration</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Generate Button -->
            <div style="text-align: center;">
                <button id="aiwcg-generateBtn" class="aiwcg-button" style="font-size: 1.25rem; padding: 1.25rem 3rem;">
                    <svg style="width: 1.5rem; height: 1.5rem; margin-right: 0.75rem; display: inline-block;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                    </svg>
                    Generate AI Website Concept
                </button>
                
                <div id="aiwcg-validation-message" class="aiwcg-validation-message aiwcg-hidden">
                    Please fill in business name and industry to continue
                </div>
            </div>
        </div>

        <!-- Loading Section -->
        <div id="aiwcg-loading-section" class="aiwcg-hidden">
            <div class="aiwcg-glass" style="text-align: center;">
                <div class="aiwcg-spinner" style="margin-bottom: 2rem;"></div>
                <h3 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 1.5rem;">AI is Creating Your Website Concept...</h3>
                
                <div id="aiwcg-progress-steps" style="max-width: 600px; margin: 0 auto;">
                    <div class="aiwcg-progress-step">
                        <div style="display: flex; align-items: center;">
                            <div style="width: 1rem; height: 1rem; border: 2px solid #6b7280; border-radius: 50%; margin-right: 0.75rem;"></div>
                            Analyzing your business requirements...
                        </div>
                    </div>
                    <div class="aiwcg-progress-step">
                        <div style="display: flex; align-items: center;">
                            <div style="width: 1rem; height: 1rem; border: 2px solid #6b7280; border-radius: 50%; margin-right: 0.75rem;"></div>
                            Researching industry best practices...
                        </div>
                    </div>
                    <div class="aiwcg-progress-step">
                        <div style="display: flex; align-items: center;">
                            <div style="width: 1rem; height: 1rem; border: 2px solid #6b7280; border-radius: 50%; margin-right: 0.75rem;"></div>
                            Generating detailed wireframes...
                        </div>
                    </div>
                    <div class="aiwcg-progress-step">
                        <div style="display: flex; align-items: center;">
                            <div style="width: 1rem; height: 1rem; border: 2px solid #6b7280; border-radius: 50%; margin-right: 0.75rem;"></div>
                            Creating color palettes and design concepts...
                        </div>
                    </div>
                    <div class="aiwcg-progress-step">
                        <div style="display: flex; align-items: center;">
                            <div style="width: 1rem; height: 1rem; border: 2px solid #6b7280; border-radius: 50%; margin-right: 0.75rem;"></div>
                            Calculating costs and timelines...
                        </div>
                    </div>
                    <div class="aiwcg-progress-step">
                        <div style="display: flex; align-items: center;">
                            <div style="width: 1rem; height: 1rem; border: 2px solid #6b7280; border-radius: 50%; margin-right: 0.75rem;"></div>
                            Finalizing technical specifications...
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Results Section -->
        <div id="aiwcg-results-section" class="aiwcg-hidden">
            <!-- Results content will be populated by JavaScript -->
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const formData = {
                businessType: '',
                industry: '',
                companySize: '',
                targetAudience: '',
                businessGoal: '',
                budget: '',
                businessDescription: '',
                timeline: '',
                currentWebsite: '',
                websiteType: '',
                designStyle: '',
                features: []
            };

            // Initialize event listeners
            initializeFormListeners();
            
            function initializeFormListeners() {
                // Text inputs
                ['businessType', 'targetAudience', 'businessDescription'].forEach(id => {
                    const element = document.getElementById('aiwcg-' + id);
                    if (element) {
                        element.addEventListener('input', function() {
                            formData[id] = this.value;
                            validateForm();
                        });
                    }
                });

                // Select inputs
                ['industry', 'companySize', 'businessGoal', 'budget', 'timeline', 'currentWebsite'].forEach(id => {
                    const element = document.getElementById('aiwcg-' + id);
                    if (element) {
                        element.addEventListener('change', function() {
                            formData[id] = this.value;
                            validateForm();
                        });
                    }
                });

                // Website type selection
                document.querySelectorAll('.aiwcg-website-type').forEach(button => {
                    button.addEventListener('click', function() {
                        document.querySelectorAll('.aiwcg-website-type').forEach(btn => btn.classList.remove('selected'));
                        this.classList.add('selected');
                        formData.websiteType = this.getAttribute('data-value');
                    });
                });

                // Design style selection
                document.querySelectorAll('.aiwcg-design-style').forEach(button => {
                    button.addEventListener('click', function() {
                        document.querySelectorAll('.aiwcg-design-style').forEach(btn => btn.classList.remove('selected'));
                        this.classList.add('selected');
                        formData.designStyle = this.getAttribute('data-value');
                    });
                });

                // Feature selection
                document.querySelectorAll('.aiwcg-feature').forEach(button => {
                    button.addEventListener('click', function() {
                        const value = this.getAttribute('data-value');
                        if (formData.features.includes(value)) {
                            formData.features = formData.features.filter(f => f !== value);
                            this.classList.remove('selected');
                        } else {
                            formData.features.push(value);
                            this.classList.add('selected');
                        }
                    });
                });

                // Generate button
                document.getElementById('aiwcg-generateBtn').addEventListener('click', function() {
                    if (validateForm()) {
                        generateConcept();
                    }
                });
            }

            function validateForm() {
                const isValid = formData.businessType && formData.industry;
                const validationMessage = document.getElementById('aiwcg-validation-message');
                const generateBtn = document.getElementById('aiwcg-generateBtn');

                if (isValid) {
                    validationMessage.classList.add('aiwcg-hidden');
                    generateBtn.disabled = false;
                    generateBtn.style.opacity = '1';
                    return true;
                } else {
                    validationMessage.classList.remove('aiwcg-hidden');
                    generateBtn.disabled = true;
                    generateBtn.style.opacity = '0.5';
                    return false;
                }
            }

            async function generateConcept() {
                // Hide form and show loading
                document.getElementById('aiwcg-form-section').classList.add('aiwcg-hidden');
                document.getElementById('aiwcg-loading-section').classList.remove('aiwcg-hidden');

                // Animate progress steps
                const steps = document.querySelectorAll('.aiwcg-progress-step');
                for (let i = 0; i < steps.length; i++) {
                    await new Promise(resolve => setTimeout(resolve, 800));
                    
                    steps[i].classList.add('active');
                    const iconContainer = steps[i].querySelector('div div');
                    iconContainer.innerHTML = `
                        <svg style="width: 1rem; height: 1rem; margin-right: 0.75rem; color: #22c55e;" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                    `;
                }

                try {
                    const formDataObj = new FormData();
                    formDataObj.append('action', 'generate_concept');
                    formDataObj.append('nonce', aiwcg_ajax.nonce);
                    formDataObj.append('form_data', JSON.stringify(formData));

                    const response = await fetch(aiwcg_ajax.ajax_url, {
                        method: 'POST',
                        body: formDataObj
                    });

                    const result = await response.json();

                    if (result.success) {
                        displayResults(result.data);
                    } else {
                        throw new Error(result.data || 'Generation failed');
                    }
                } catch (error) {
                    console.error('Error generating concept:', error);
                    displayError(error.message);
                }

                // Hide loading and show results
                document.getElementById('aiwcg-loading-section').classList.add('aiwcg-hidden');
                document.getElementById('aiwcg-results-section').classList.remove('aiwcg-hidden');
                document.getElementById('aiwcg-results-section').scrollIntoView({ behavior: 'smooth' });
            }

            function displayResults(data) {
                const resultsSection = document.getElementById('aiwcg-results-section');
                
                resultsSection.innerHTML = `
                    <div class="aiwcg-results-header">
                        <div class="aiwcg-success-icon">
                            <svg style="width: 2rem; height: 2rem; color: white;" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <h2 style="font-size: 2rem; font-weight: bold; margin-bottom: 0.5rem;">Your AI-Generated Website Concept is Ready!</h2>
                        <p style="font-size: 1.125rem; color: #d1d5db;">Complete with detailed wireframes, technical specifications, and cost projections</p>
                    </div>

                    <!-- Concept Overview -->
                    <div class="aiwcg-glass" style="background: linear-gradient(135deg, rgba(124, 58, 237, 0.2), rgba(59, 130, 246, 0.2)); border: 1px solid rgba(124, 58, 237, 0.3);">
                        <div style="display: flex; justify-content: between; align-items: start; margin-bottom: 1.5rem;">
                            <div>
                                <h2 style="font-size: 2rem; font-weight: bold; margin-bottom: 0.5rem;">${data.concept.title}</h2>
                                <p style="font-size: 1.25rem; color: #c4b5fd; font-weight: 500; margin-bottom: 1rem;">"${data.concept.tagline}"</p>
                            </div>
                            <button onclick="resetGenerator()" style="padding: 0.75rem; background: rgba(55, 65, 81, 0.5); border: none; border-radius: 0.5rem; color: #d1d5db; cursor: pointer;" title="Generate New Concept">
                                <svg style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                            </button>
                        </div>
                        
                        <p style="font-size: 1.125rem; line-height: 1.7; margin-bottom: 2rem;">${data.concept.description}</p>

                        <div class="aiwcg-grid" style="grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
                            <div class="aiwcg-metric-card">
                                <div class="aiwcg-metric-value" style="color: #22c55e;">${data.concept.estimatedCost}</div>
                                <div class="aiwcg-metric-label">Estimated Cost</div>
                            </div>
                            <div class="aiwcg-metric-card">
                                <div class="aiwcg-metric-value" style="color: #3b82f6;">${data.concept.timeline}</div>
                                <div class="aiwcg-metric-label">Timeline</div>
                            </div>
                            <div class="aiwcg-metric-card">
                                <div class="aiwcg-metric-value" style="color: #8b5cf6;">${data.concept.pages}</div>
                                <div class="aiwcg-metric-label">Pages</div>
                            </div>
                            <div class="aiwcg-metric-card">
                                <div class="aiwcg-metric-value" style="color: #f59e0b;">${data.performance.seoScore}/100</div>
                                <div class="aiwcg-metric-label">SEO Score</div>
                            </div>
                        </div>

                        ${data.concept.sections ? `
                        <div>
                            <h4 style="font-weight: 600; margin-bottom: 1rem;">Recommended Website Sections:</h4>
                            <div class="aiwcg-grid aiwcg-grid-2" style="gap: 0.75rem;">
                                ${data.concept.sections.map(section => `
                                    <div style="display: flex; align-items: center; color: #d1d5db;">
                                        <div style="width: 0.5rem; height: 0.5rem; background: #8b5cf6; border-radius: 50%; margin-right: 0.75rem;"></div>
                                        ${section}
                                    </div>
                                `).join('')}
                            </div>
                        </div>
                        ` : ''}
                    </div>

                    <!-- Wireframes -->
                    ${data.wireframes ? `
                    <div class="aiwcg-glass">
                        <h3 class="aiwcg-section-title">
                            <svg class="aiwcg-section-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            Homepage Wireframe Structure
                        </h3>
                        
                        <div style="background: rgba(31, 41, 55, 0.3); border-radius: 0.5rem; padding: 1.5rem;">
                            ${data.wireframes.homepage.sections.map(section => `
                                <div class="aiwcg-wireframe-section" 
                                     style="height: ${Math.max(section.height * 0.15, 35)}px; background-color: ${section.color}; margin-bottom: 0.5rem;"
                                     title="${section.description}">
                                    <div style="text-align: center;">
                                        <div style="font-weight: 600;">${section.name}</div>
                                        <div style="font-size: 0.75rem; opacity: 0.8;">${section.description}</div>
                                    </div>
                                </div>
                            `).join('')}
                        </div>

                        ${data.wireframes.additionalPages ? `
                        <div style="margin-top: 2rem;">
                            <h4 style="font-weight: 600; margin-bottom: 1rem;">Additional Pages Structure:</h4>
                            <div class="aiwcg-grid aiwcg-grid-2" style="gap: 1rem;">
                                ${data.wireframes.additionalPages.map(page => `
                                    <div style="background: rgba(31, 41, 55, 0.3); border-radius: 0.5rem; padding: 1rem;">
                                        <h5 style="font-weight: 600; margin-bottom: 0.5rem; color: #8b5cf6;">${page.name}</h5>
                                        <p style="font-size: 0.875rem; color: #d1d5db; margin-bottom: 0.75rem;">${page.purpose}</p>
                                        <div style="font-size: 0.75rem;">
                                            <strong>Key Elements:</strong>
                                            <ul style="margin: 0.25rem 0 0 1rem; color: #9ca3af;">
                                                ${page.keyElements.map(element => `<li>${element}</li>`).join('')}
                                            </ul>
                                        </div>
                                    </div>
                                `).join('')}
                            </div>
                        </div>
                        ` : ''}
                    </div>
                    ` : ''}

                    <!-- Color Scheme -->
                    ${data.colorScheme ? `
                    <div class="aiwcg-glass">
                        <h3 class="aiwcg-section-title">
                            <svg class="aiwcg-section-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM21 5a2 2 0 00-2-2h-4a2 2 0 00-2 2v12a4 4 0 004 4h4a2 2 0 002-2V5z" />
                            </svg>
                            Color Palette & Design Rationale
                        </h3>
                        
                        <div class="aiwcg-grid" style="grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); gap: 1rem; margin-bottom: 1.5rem;">
                            ${Object.entries(data.colorScheme).filter(([key]) => key !== 'rationale').map(([name, color]) => `
                                <div style="text-align: center;">
                                    <div class="aiwcg-color-swatch" style="background-color: ${color};"></div>
                                    <div style="font-size: 0.75rem; text-transform: capitalize; margin-bottom: 0.25rem;">${name}</div>
                                    <div style="font-size: 0.75rem; font-family: monospace; color: #9ca3af;">${color}</div>
                                </div>
                            `).join('')}
                        </div>
                        
                        ${data.colorScheme.rationale ? `
                        <div style="background: rgba(31, 41, 55, 0.3); border-radius: 0.5rem; padding: 1rem;">
                            <strong>Design Rationale:</strong> ${data.colorScheme.rationale}
                        </div>
                        ` : ''}
                    </div>
                    ` : ''}

                    <!-- Features & Technology -->
                    <div class="aiwcg-grid aiwcg-grid-2">
                        ${data.features ? `
                        <div class="aiwcg-glass">
                            <h3 class="aiwcg-section-title">
                                <svg class="aiwcg-section-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Recommended Features
                            </h3>
                            
                            <div style="display: grid; gap: 1rem;">
                                ${data.features.essential ? `
                                <div class="aiwcg-feature-badge essential">
                                    <div style="display: flex; align-items: center; margin-bottom: 0.5rem;">
                                        <svg style="width: 1rem; height: 1rem; margin-right: 0.5rem; color: #22c55e;" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                        <span style="font-weight: 600; color: #22c55e;">Essential Features</span>
                                    </div>
                                    <div style="font-size: 0.875rem; line-height: 1.4;">
                                        ${data.features.essential.map(feature => `• ${feature}`).join('<br>')}
                                    </div>
                                </div>
                                ` : ''}
                                
                                ${data.features.recommended ? `
                                <div class="aiwcg-feature-badge recommended">
                                    <div style="display: flex; align-items: center; margin-bottom: 0.5rem;">
                                        <svg style="width: 1rem; height: 1rem; margin-right: 0.5rem; color: #3b82f6;" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                        <span style="font-weight: 600; color: #3b82f6;">Recommended Features</span>
                                    </div>
                                    <div style="font-size: 0.875rem; line-height: 1.4;">
                                        ${data.features.recommended.map(feature => `• ${feature}`).join('<br>')}
                                    </div>
                                </div>
                                ` : ''}
                                
                                ${data.features.advanced ? `
                                <div class="aiwcg-feature-badge advanced">
                                    <div style="display: flex; align-items: center; margin-bottom: 0.5rem;">
                                        <svg style="width: 1rem; height: 1rem; margin-right: 0.5rem; color: #8b5cf6;" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                        <span style="font-weight: 600; color: #8b5cf6;">Advanced Features</span>
                                    </div>
                                    <div style="font-size: 0.875rem; line-height: 1.4;">
                                        ${data.features.advanced.map(feature => `• ${feature}`).join('<br>')}
                                    </div>
                                </div>
                                ` : ''}
                            </div>
                        </div>
                        ` : ''}

                        ${data.concept.technologyStack ? `
                        <div class="aiwcg-glass">
                            <h3 class="aiwcg-section-title">
                                <svg class="aiwcg-section-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                                </svg>
                                Technology Stack
                            </h3>
                            
                            <div style="display: grid; gap: 0.75rem;">
                                ${data.concept.technologyStack.map(tech => `
                                    <div style="background: rgba(31, 41, 55, 0.3); padding: 0.75rem; border-radius: 0.5rem; display: flex; align-items: center;">
                                        <div style="width: 0.5rem; height: 0.5rem; background: #8b5cf6; border-radius: 50%; margin-right: 0.75rem;"></div>
                                        ${tech}
                                    </div>
                                `).join('')}
                            </div>
                        </div>
                        ` : ''}
                    </div>

                    <!-- Performance Metrics -->
                    ${data.performance ? `
                    <div class="aiwcg-glass">
                        <h3 class="aiwcg-section-title">
                            <svg class="aiwcg-section-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                            Expected Performance Metrics
                        </h3>
                        
                        <div class="aiwcg-grid" style="grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
                            ${Object.entries(data.performance).map(([metric, score]) => {
                                const colors = {
                                    seoScore: '#22c55e',
                                    performanceScore: '#3b82f6', 
                                    accessibilityScore: '#8b5cf6',
                                    mobileScore: '#f59e0b'
                                };
                                const labels = {
                                    seoScore: 'SEO Optimization',
                                    performanceScore: 'Page Speed',
                                    accessibilityScore: 'Accessibility',
                                    mobileScore: 'Mobile Experience'
                                };
                                return `
                                    <div style="background: rgba(31, 41, 55, 0.3); padding: 1rem; border-radius: 0.5rem;">
                                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                                            <span style="font-size: 0.875rem;">${labels[metric] || metric}</span>
                                            <span style="font-weight: 600; color: ${colors[metric] || '#d1d5db'};">${score}/100</span>
                                        </div>
                                        <div style="width: 100%; background: #374151; border-radius: 9999px; height: 0.5rem;">
                                            <div style="background: ${colors[metric] || '#d1d5db'}; height: 100%; border-radius: 9999px; width: ${score}%;"></div>
                                        </div>
                                    </div>
                                `;
                            }).join('')}
                        </div>
                    </div>
                    ` : ''}

                    <!-- Content & Strategy -->
                    ${(data.concept.contentStrategy || data.concept.seoStrategy) ? `
                    <div class="aiwcg-glass">
                        <h3 class="aiwcg-section-title">
                            <svg class="aiwcg-section-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Content & SEO Strategy
                        </h3>
                        
                        <div class="aiwcg-grid aiwcg-grid-2" style="gap: 1.5rem;">
                            ${data.concept.contentStrategy ? `
                            <div>
                                <h4 style="font-weight: 600; margin-bottom: 0.75rem; color: #3b82f6;">Content Strategy</h4>
                                <p style="color: #d1d5db; line-height: 1.6;">${data.concept.contentStrategy}</p>
                            </div>
                            ` : ''}
                            
                            ${data.concept.seoStrategy ? `
                            <div>
                                <h4 style="font-weight: 600; margin-bottom: 0.75rem; color: #22c55e;">SEO Strategy</h4>
                                <p style="color: #d1d5db; line-height: 1.6;">${data.concept.seoStrategy}</p>
                            </div>
                            ` : ''}
                        </div>
                    </div>
                    ` : ''}

                    <!-- Action Buttons -->
                    <div class="aiwcg-grid aiwcg-grid-3" style="gap: 1rem;">
                        <button onclick="downloadConcept()" class="aiwcg-button" style="background: linear-gradient(to right, #22c55e, #16a34a);">
                            <svg style="width: 1.25rem; height: 1.25rem; margin-right: 0.5rem; display: inline-block;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Download Concept
                        </button>
                        
                        <button onclick="generateDemo()" class="aiwcg-button" style="background: linear-gradient(to right, #f97316, #ea580c);">
                            <svg style="width: 1.25rem; height: 1.25rem; margin-right: 0.5rem; display: inline-block;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Build Live Demo
                        </button>
                        
                        <button onclick="requestQuote()" class="aiwcg-button">
                            <svg style="width: 1.25rem; height: 1.25rem; margin-right: 0.5rem; display: inline-block;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                            </svg>
                            Request Quote
                        </button>
                    </div>
                `;
            }

            function displayError(message) {
                const resultsSection = document.getElementById('aiwcg-results-section');
                resultsSection.innerHTML = `
                    <div class="aiwcg-glass" style="text-align: center; background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.3);">
                        <div style="width: 4rem; height: 4rem; background: #ef4444; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem;">
                            <svg style="width: 2rem; height: 2rem; color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </div>
                        <h3 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 1rem; color: #ef4444;">Generation Failed</h3>
                        <p style="color: #d1d5db; margin-bottom: 2rem;">${message}</p>
                        <button onclick="resetGenerator()" class="aiwcg-button">Try Again</button>
                    </div>
                `;
            }

            // Global functions for button actions
            window.resetGenerator = function() {
                // Reset form
                Object.keys(formData).forEach(key => {
                    if (key === 'features') {
                        formData[key] = [];
                    } else {
                        formData[key] = '';
                    }
                });

                // Reset form inputs
                document.querySelectorAll('.aiwcg-input, .aiwcg-select, .aiwcg-textarea').forEach(input => {
                    input.value = '';
                });

                // Reset selections
                document.querySelectorAll('.aiwcg-option-button').forEach(btn => {
                    btn.classList.remove('selected');
                });

                // Reset progress steps
                document.querySelectorAll('.aiwcg-progress-step').forEach(step => {
                    step.classList.remove('active');
                    const icon = step.querySelector('div div');
                    if (icon) {
                        icon.innerHTML = '<div style="width: 1rem; height: 1rem; border: 2px solid #6b7280; border-radius: 50%; margin-right: 0.75rem;"></div>';
                    }
                });

                // Show form, hide others
                document.getElementById('aiwcg-form-section').classList.remove('aiwcg-hidden');
                document.getElementById('aiwcg-loading-section').classList.add('aiwcg-hidden');
                document.getElementById('aiwcg-results-section').classList.add('aiwcg-hidden');

                validateForm();
            };

            window.downloadConcept = function() {
                alert('Download feature coming soon! The concept will be available as a PDF report.');
            };

            window.generateDemo = function() {
                alert('Live demo generation feature coming soon! This will create a working prototype of your website.');
            };

            window.requestQuote = function() {
                alert('Quote request feature coming soon! This will connect you with our development team.');
            };
        });
    </script>
</div>