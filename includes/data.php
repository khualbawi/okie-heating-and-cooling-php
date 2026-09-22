<?php
declare(strict_types=1);

// ---------------------------------------------------------------------------
// Services (ported 1:1 from src/lib/services-data.js)
// ---------------------------------------------------------------------------
const SERVICES = [
    [
        'slug' => 'ac-repair', 'title' => 'AC Repair', 'shortTitle' => 'AC Repair', 'category' => 'cooling', 'icon' => 'snowflake', 'formValue' => 'ac_repair',
        'heroHeadline' => 'Fast, Reliable AC Repair in Tulsa, OK',
        'heroSubheadline' => "When your air conditioning breaks down in the Oklahoma heat, you need a team that shows up fast and fixes it right the first time.",
        'description' => "Don't suffer through Tulsa's brutal summers with a broken AC. Our certified technicians diagnose and repair all makes and models of air conditioning systems, getting your home cool and comfortable again — fast.",
        'benefits' => ['Same-day AC repair service available', 'All makes and models serviced', 'Upfront, honest pricing — no surprises', 'EPA-certified, background-checked technicians', 'Parts and labor warranty included'],
        'symptoms' => ['AC blowing warm or lukewarm air', 'Unusual noises from the outdoor unit', 'AC running but not cooling evenly', 'System short cycling on and off', 'High electricity bills without explanation', 'Ice forming on the evaporator coil', 'Water leaking around the indoor unit'],
        'process' => [
            ['step' => 'Call or Book Online', 'detail' => "Reach out 24/7 and we'll schedule your repair visit, often same-day."],
            ['step' => 'Expert Diagnosis', 'detail' => 'Our technician performs a thorough inspection of your entire AC system.'],
            ['step' => 'Upfront Quote', 'detail' => 'We explain the issue and give you a clear price before any work begins.'],
            ['step' => 'Professional Repair', 'detail' => 'We fix it right the first time using quality parts and proven techniques.'],
        ],
        'faqs' => [
            ['q' => 'How quickly can you repair my AC?', 'a' => 'We offer same-day service for most AC repairs in the Tulsa metro area. For emergencies, we can often arrive within a few hours.'],
            ['q' => 'Do you charge a diagnostic fee?', 'a' => 'We charge a reasonable service call fee that covers the diagnostic visit. If you proceed with the repair, the fee is applied toward the total cost.'],
            ['q' => 'What brands do you repair?', 'a' => 'We service all major AC brands including Carrier, Trane, Lennox, Rheem, Goodman, Daikin, and many more.'],
            ['q' => 'Is it better to repair or replace my AC?', 'a' => "It depends on the age of the unit, repair cost, and efficiency. If your AC is over 12-15 years old and the repair is costly, replacement may be the better long-term investment. We'll give you honest advice."],
        ],
        'seoText' => 'Looking for trusted AC repair in Tulsa, Oklahoma? Okie Heating and Cooling provides fast, affordable air conditioning repair services across the Tulsa metro area. Our experienced HVAC technicians are available for same-day AC repairs in Tulsa, Broken Arrow, Owasso, Bixby, Jenks, and surrounding communities. Whether your central air stopped working, your AC is blowing warm air, or you hear strange noises from your unit, we diagnose and fix the problem quickly with upfront pricing and no hidden fees.',
    ],
    [
        'slug' => 'ac-installation', 'title' => 'AC Installation', 'shortTitle' => 'AC Install', 'category' => 'cooling', 'icon' => 'fan', 'formValue' => 'ac_installation',
        'heroHeadline' => 'Expert AC Installation in Tulsa, OK',
        'heroSubheadline' => "Upgrade your comfort with a professionally installed, high-efficiency air conditioning system built for Oklahoma's climate.",
        'description' => "Whether you're replacing an aging unit or installing central air for the first time, our team ensures your new AC system is sized correctly, installed to manufacturer specifications, and optimized for peak performance and efficiency.",
        'benefits' => ['Free in-home consultation and estimate', 'Properly sized systems for your home', 'Energy-efficient options to lower bills', 'Manufacturer warranty protection', 'Clean, respectful installation process'],
        'symptoms' => ['Current AC is over 12-15 years old', 'Frequent costly repairs adding up', 'Rooms that never cool properly', 'Energy bills climbing each summer', 'Building a new home or addition', 'Current system uses R-22 refrigerant'],
        'process' => [
            ['step' => 'Free Consultation', 'detail' => 'We visit your home, assess your cooling needs, and recommend the best options.'],
            ['step' => 'Custom Proposal', 'detail' => 'You receive a detailed quote with equipment options, efficiency ratings, and financing.'],
            ['step' => 'Professional Installation', 'detail' => 'Our team installs your new system with care, following all codes and best practices.'],
            ['step' => 'Testing & Walkthrough', 'detail' => "We test everything, walk you through operation, and make sure you're 100% satisfied."],
        ],
        'faqs' => [
            ['q' => 'How much does a new AC system cost in Tulsa?', 'a' => "AC installation costs vary based on system size, efficiency rating, and your home's needs. We provide free estimates and offer financing to make it affordable."],
            ['q' => 'How long does AC installation take?', 'a' => 'Most residential AC installations are completed in one day. Complex installations or ductwork modifications may take slightly longer.'],
            ['q' => 'What size AC do I need?', 'a' => "System sizing depends on your home's square footage, insulation, windows, and other factors. We perform a Manual J load calculation to determine the perfect size."],
            ['q' => 'Do you offer financing?', 'a' => 'Yes! We offer flexible financing options to help you invest in comfort without breaking the bank.'],
        ],
        'seoText' => 'Need a new air conditioning system installed in Tulsa? Okie Heating and Cooling offers professional AC installation services throughout the Tulsa metro area. We install all major brands and help you choose the right high-efficiency system for your home and budget.',
    ],
    [
        'slug' => 'ac-maintenance', 'title' => 'AC Maintenance', 'shortTitle' => 'AC Tune-Up', 'category' => 'cooling', 'icon' => 'settings', 'formValue' => 'ac_maintenance',
        'heroHeadline' => 'AC Maintenance & Tune-Ups in Tulsa, OK',
        'heroSubheadline' => "Keep your air conditioner running at peak performance with professional preventive maintenance from Tulsa's trusted HVAC team.",
        'description' => 'Regular AC maintenance prevents breakdowns, extends equipment life, and keeps your energy bills low. Our thorough tune-up service covers everything your system needs to run efficiently all summer long.',
        'benefits' => ['Prevent costly breakdowns', 'Lower energy bills', 'Extend equipment lifespan', 'Maintain manufacturer warranty', 'Improve indoor air quality'],
        'symptoms' => ["Haven't had a tune-up in over a year", 'AC not cooling as well as it used to', 'Energy bills creeping up', 'System running louder than normal', 'Dusty or musty air from vents'],
        'process' => [
            ['step' => 'Schedule Your Tune-Up', 'detail' => 'Book online or call us to schedule at a convenient time.'],
            ['step' => 'Comprehensive Inspection', 'detail' => 'We check refrigerant levels, electrical connections, coils, filters, and more.'],
            ['step' => 'Clean & Optimize', 'detail' => 'We clean components, lubricate parts, and optimize settings for peak performance.'],
            ['step' => 'Detailed Report', 'detail' => "You receive a full report of your system's condition and any recommendations."],
        ],
        'faqs' => [
            ['q' => 'How often should I have my AC maintained?', 'a' => 'We recommend professional maintenance at least once per year, ideally in spring before the cooling season begins.'],
            ['q' => "What's included in an AC tune-up?", 'a' => 'Our tune-up includes checking refrigerant, cleaning coils, inspecting electrical connections, testing controls, replacing filters, and a full system performance check.'],
        ],
        'seoText' => 'Schedule professional AC maintenance in Tulsa with Okie Heating and Cooling. Our comprehensive tune-up service keeps your air conditioner running efficiently, prevents unexpected breakdowns, and saves you money on energy bills.',
    ],
    [
        'slug' => 'heating-repair', 'title' => 'Heating Repair', 'shortTitle' => 'Heat Repair', 'category' => 'heating', 'icon' => 'flame', 'formValue' => 'heating_repair',
        'heroHeadline' => 'Heating Repair Services in Tulsa, OK',
        'heroSubheadline' => 'When your heater stops working on a cold Oklahoma night, count on Okie Heating and Cooling for fast, dependable repair.',
        'description' => 'From heat pumps to gas furnaces, our technicians diagnose and repair heating systems quickly and correctly. We keep Tulsa homes warm and safe all winter.',
        'benefits' => ['Fast response, even in emergencies', 'All heating system types serviced', 'Transparent pricing before repairs begin', 'Safety-first approach for gas systems', 'Satisfaction guaranteed'],
        'symptoms' => ['No heat coming from vents', 'Heater running but not warming the house', 'Strange smells when the heater runs', "Pilot light won't stay lit", 'Thermostat not responding', 'Carbon monoxide detector triggered'],
        'process' => [
            ['step' => 'Contact Us', 'detail' => 'Call or book online — we prioritize heating emergencies.'],
            ['step' => 'Thorough Diagnosis', 'detail' => 'Our technician inspects your heating system to find the root cause.'],
            ['step' => 'Clear Pricing', 'detail' => 'You approve the repair cost before we begin any work.'],
            ['step' => 'Expert Repair', 'detail' => 'We restore your heat using quality parts and proven methods.'],
        ],
        'faqs' => [
            ['q' => 'Why is my heater blowing cold air?', 'a' => 'Common causes include a faulty thermostat, clogged filter, pilot light issue, or a malfunctioning heat exchanger. Our technicians can diagnose the exact cause.'],
            ['q' => 'Is it safe to keep using my heater if it smells strange?', 'a' => 'If you smell gas or a burning smell, turn off your heater immediately and call us. Strange smells can indicate safety hazards that need professional attention.'],
        ],
        'seoText' => 'Fast, reliable heating repair in Tulsa, OK. Okie Heating and Cooling fixes furnaces, heat pumps, and all heating systems. Same-day service available for Tulsa, Broken Arrow, Owasso, and surrounding areas.',
    ],
    [
        'slug' => 'heating-installation', 'title' => 'Heating Installation', 'shortTitle' => 'Heat Install', 'category' => 'heating', 'icon' => 'thermometer-sun', 'formValue' => 'heating_installation',
        'heroHeadline' => 'Heating System Installation in Tulsa, OK',
        'heroSubheadline' => 'Invest in reliable warmth with a professionally installed heating system designed for your home and Oklahoma winters.',
        'description' => 'We install furnaces, heat pumps, and complete heating systems with expert precision. Get the right system for your home, properly sized and installed for maximum comfort and efficiency.',
        'benefits' => ['Free in-home estimates', 'Energy-efficient system options', 'Expert sizing and installation', 'All major brands available', 'Financing options available'],
        'symptoms' => ['Heating system over 15 years old', 'Frequent and expensive repairs', 'Uneven heating throughout home', 'Rising heating bills', 'Home addition needs new heating'],
        'process' => [
            ['step' => 'Free Home Assessment', 'detail' => "We evaluate your home's heating needs and recommend the best options."],
            ['step' => 'Detailed Proposal', 'detail' => 'Choose from options that fit your comfort goals and budget.'],
            ['step' => 'Expert Installation', 'detail' => 'Our team installs your new system to the highest standards.'],
            ['step' => 'Final Testing', 'detail' => 'We verify performance, explain operation, and ensure your satisfaction.'],
        ],
        'faqs' => [
            ['q' => 'What type of heating system is best for Tulsa?', 'a' => "Oklahoma's climate works well with gas furnaces, heat pumps, or dual-fuel systems. We'll recommend the best option based on your home and preferences."],
            ['q' => 'How long does a heating installation take?', 'a' => "Most installations are completed in one day. We'll give you a timeline during your consultation."],
        ],
        'seoText' => 'Professional heating installation in Tulsa, OK. Okie Heating and Cooling installs furnaces, heat pumps, and heating systems throughout the Tulsa metro area with expert precision and financing options.',
    ],
    [
        'slug' => 'heating-maintenance', 'title' => 'Heating Maintenance', 'shortTitle' => 'Heat Tune-Up', 'category' => 'heating', 'icon' => 'wrench', 'formValue' => 'heating_maintenance',
        'heroHeadline' => 'Heating Maintenance in Tulsa, OK',
        'heroSubheadline' => "Prevent mid-winter breakdowns with professional heating tune-ups from Tulsa's trusted HVAC experts.",
        'description' => 'Annual heating maintenance keeps your system safe, efficient, and reliable. Our comprehensive tune-up covers safety checks, performance optimization, and early problem detection.',
        'benefits' => ['Prevent winter breakdowns', 'Ensure safe operation', 'Improve energy efficiency', 'Catch small issues early', 'Maintain warranty coverage'],
        'symptoms' => ['No maintenance in over a year', 'Heater seems less efficient', 'Higher than normal gas bills', 'System making new noises', 'Uneven heating in rooms'],
        'process' => [
            ['step' => 'Schedule Service', 'detail' => 'Book your heating tune-up at a convenient time.'],
            ['step' => 'Safety Inspection', 'detail' => 'We check heat exchangers, gas connections, carbon monoxide levels, and more.'],
            ['step' => 'Performance Tune-Up', 'detail' => 'We clean, adjust, and optimize your heating system.'],
            ['step' => 'Report & Recommendations', 'detail' => "You receive a detailed report on your system's condition."],
        ],
        'faqs' => [
            ['q' => 'When should I schedule heating maintenance?', 'a' => 'Ideally in early fall, before the heating season starts. This ensures your system is ready when you need it most.'],
        ],
        'seoText' => 'Keep your heater running safely and efficiently with professional heating maintenance from Okie Heating and Cooling in Tulsa, OK. Schedule your annual tune-up today.',
    ],
    [
        'slug' => 'furnace-repair', 'title' => 'Furnace Repair', 'shortTitle' => 'Furnace Repair', 'category' => 'heating', 'icon' => 'flame', 'formValue' => 'furnace_repair',
        'heroHeadline' => 'Furnace Repair in Tulsa, OK',
        'heroSubheadline' => "Expert furnace repair from Tulsa's trusted heating professionals. We fix all brands and models quickly and safely.",
        'description' => 'A broken furnace in winter is more than inconvenient — it can be dangerous. Our technicians specialize in diagnosing and repairing gas and electric furnaces with speed and precision.',
        'benefits' => ['Same-day furnace repair available', 'Gas and electric furnaces serviced', 'Safety-first approach', 'All major brands', 'Clear, upfront pricing'],
        'symptoms' => ["Furnace won't turn on", 'Blowing cold air', 'Yellow or flickering pilot light', 'Frequent cycling', 'Carbon monoxide concerns', 'Strange noises or smells'],
        'process' => [
            ['step' => 'Call Us', 'detail' => 'We prioritize furnace repairs, especially in cold weather.'],
            ['step' => 'Expert Diagnosis', 'detail' => 'We identify the problem and check for safety concerns.'],
            ['step' => 'Honest Quote', 'detail' => 'You know the cost before we start.'],
            ['step' => 'Quality Repair', 'detail' => 'We fix your furnace right, with parts backed by warranty.'],
        ],
        'faqs' => [
            ['q' => 'How do I know if my furnace needs repair or replacement?', 'a' => "If your furnace is under 15 years old and the repair cost is less than half of replacement, repair is usually the better choice. We'll give you honest guidance."],
        ],
        'seoText' => 'Trusted furnace repair in Tulsa, OK. OKIE Heating and Cooling provides fast, safe furnace repair for all brands. Serving Tulsa, Broken Arrow, Owasso, and nearby areas.',
    ],
    [
        'slug' => 'furnace-installation', 'title' => 'Furnace Installation', 'shortTitle' => 'Furnace Install', 'category' => 'heating', 'icon' => 'flame', 'formValue' => 'furnace_installation',
        'heroHeadline' => 'Furnace Installation in Tulsa, OK',
        'heroSubheadline' => "Upgrade to a modern, energy-efficient furnace installed by Tulsa's HVAC professionals.",
        'description' => "A new furnace installation is a major investment in your home's comfort and safety. We help you choose the right furnace, install it properly, and ensure it performs flawlessly for years.",
        'benefits' => ['Free consultations and estimates', 'High-efficiency furnace options', 'Expert sizing and installation', 'Full manufacturer warranty', 'Financing available'],
        'symptoms' => ['Furnace over 15-20 years old', 'Costly recurring repairs', 'Uneven heating', 'Rising gas bills', 'Safety concerns with old unit'],
        'process' => [
            ['step' => 'In-Home Consultation', 'detail' => 'We assess your home and recommend the best furnace options.'],
            ['step' => 'Custom Quote', 'detail' => 'Choose from options that fit your needs and budget.'],
            ['step' => 'Professional Installation', 'detail' => 'Installed to code with attention to detail.'],
            ['step' => 'Complete Walkthrough', 'detail' => 'We test, explain, and ensure your total satisfaction.'],
        ],
        'faqs' => [
            ['q' => 'What size furnace do I need?', 'a' => "Furnace sizing depends on your home's size, insulation, and climate zone. We calculate the right size to ensure comfort without wasted energy."],
        ],
        'seoText' => 'Professional furnace installation in Tulsa, OK. Okie Heating and Cooling helps you upgrade to a high-efficiency furnace with expert installation and flexible financing.',
    ],
    [
        'slug' => 'indoor-air-quality', 'title' => 'Indoor Air Quality', 'shortTitle' => 'Air Quality', 'category' => 'air-quality', 'icon' => 'wind', 'formValue' => 'indoor_air_quality',
        'heroHeadline' => 'Indoor Air Quality Solutions in Tulsa, OK',
        'heroSubheadline' => 'Breathe cleaner, healthier air at home with professional air quality solutions from Okie Heating and Cooling.',
        'description' => 'Poor indoor air quality affects your health, comfort, and well-being. We offer a range of solutions including air purifiers, humidifiers, UV lights, and ventilation upgrades to improve the air you breathe.',
        'benefits' => ['Reduce allergens and pollutants', 'Control humidity levels', 'Eliminate odors and VOCs', 'Protect family health', 'Whole-home solutions available'],
        'symptoms' => ['Excessive dust in the home', 'Allergy symptoms worsening indoors', 'Musty or stale air', 'Dry air in winter', 'Humidity issues in summer'],
        'process' => [
            ['step' => 'Air Quality Assessment', 'detail' => "We evaluate your home's air quality and identify concerns."],
            ['step' => 'Solution Recommendation', 'detail' => 'We recommend the right combination of products for your needs.'],
            ['step' => 'Professional Installation', 'detail' => 'We integrate air quality products with your HVAC system.'],
            ['step' => 'Ongoing Support', 'detail' => 'We maintain your air quality systems and replace filters as needed.'],
        ],
        'faqs' => [
            ['q' => 'What indoor air quality products do you recommend?', 'a' => 'Depending on your needs, we may recommend HEPA filtration, UV germicidal lights, whole-home humidifiers or dehumidifiers, and air purification systems.'],
        ],
        'seoText' => 'Improve your indoor air quality in Tulsa with Okie Heating and Cooling. We install air purifiers, humidifiers, UV lights, and ventilation systems for healthier home air.',
    ],
    [
        'slug' => 'thermostat-installation', 'title' => 'Thermostat Installation', 'shortTitle' => 'Thermostats', 'category' => 'controls', 'icon' => 'thermometer', 'formValue' => 'thermostat_installation',
        'heroHeadline' => 'Thermostat Installation in Tulsa, OK',
        'heroSubheadline' => 'Upgrade to a smart thermostat and take control of your comfort and energy costs.',
        'description' => "A modern thermostat gives you precise control over your home's temperature, helps reduce energy waste, and can even learn your preferences. We install all major smart thermostat brands.",
        'benefits' => ['Save on energy bills', 'Smart home integration', 'Precise temperature control', 'Remote access from your phone', 'Easy-to-use interfaces'],
        'symptoms' => ['Old manual thermostat', 'Inconsistent temperatures', 'Want smart home features', 'High energy bills', 'Thermostat not reading correctly'],
        'process' => [
            ['step' => 'Choose Your Thermostat', 'detail' => 'We help you select the best thermostat for your system and lifestyle.'],
            ['step' => 'Professional Installation', 'detail' => 'We install and wire your thermostat correctly for optimal performance.'],
            ['step' => 'Setup & Configuration', 'detail' => 'We program your thermostat and connect it to your WiFi and apps.'],
            ['step' => 'Quick Tutorial', 'detail' => 'We show you how to use all the features of your new thermostat.'],
        ],
        'faqs' => [
            ['q' => 'Which smart thermostats do you install?', 'a' => "We install Nest, Ecobee, Honeywell Home, and other popular smart thermostats. We'll recommend the best fit for your HVAC system."],
        ],
        'seoText' => 'Professional thermostat installation in Tulsa, OK. Upgrade to a smart thermostat with Okie Heating and Cooling for better comfort and energy savings.',
    ],
    [
        'slug' => 'ductwork-services', 'title' => 'Ductwork Services', 'shortTitle' => 'Ductwork', 'category' => 'ductwork', 'icon' => 'air-vent', 'formValue' => 'ductwork',
        'heroHeadline' => 'Ductwork Services in Tulsa, OK',
        'heroSubheadline' => 'Properly designed and sealed ductwork is essential for comfort and efficiency. We install, repair, and optimize duct systems.',
        'description' => "Leaky or poorly designed ductwork can waste up to 30% of your heating and cooling energy. We provide duct installation, repair, sealing, and cleaning to maximize your HVAC system's performance.",
        'benefits' => ['Improve airflow and comfort', 'Reduce energy waste', 'Eliminate hot and cold spots', 'Quieter HVAC operation', 'Better indoor air quality'],
        'symptoms' => ['Rooms that are always too hot or cold', 'Excessive dust from vents', 'Noisy ductwork', 'High energy bills', 'Visible duct damage or disconnection'],
        'process' => [
            ['step' => 'Duct Inspection', 'detail' => 'We inspect your ductwork for leaks, damage, and design issues.'],
            ['step' => 'Solution Plan', 'detail' => 'We recommend repairs, sealing, or replacement as needed.'],
            ['step' => 'Expert Service', 'detail' => 'Our team performs the work with minimal disruption to your home.'],
            ['step' => 'Verification', 'detail' => 'We test airflow to confirm improved performance.'],
        ],
        'faqs' => [
            ['q' => 'How do I know if my ductwork needs attention?', 'a' => 'Signs include uneven temperatures, excessive dust, high energy bills, and audible air leaks. A professional inspection can identify hidden issues.'],
        ],
        'seoText' => 'Ductwork installation, repair, and sealing in Tulsa, OK. Okie Heating and Cooling optimizes your duct system for better comfort and energy efficiency.',
    ],
    [
        'slug' => 'emergency-hvac', 'title' => 'Emergency HVAC Service', 'shortTitle' => 'Emergency', 'category' => 'emergency', 'icon' => 'alert-triangle', 'formValue' => 'emergency',
        'heroHeadline' => '24/7 Emergency HVAC Service in Tulsa, OK',
        'heroSubheadline' => "HVAC emergency? We're here around the clock. Fast response when you need it most.",
        'description' => 'When your heating or cooling system fails at the worst possible time, Okie Heating and Cooling is here for you. Our emergency technicians are available 24/7 to restore your comfort and safety.',
        'benefits' => ['Available 24 hours a day, 7 days a week', 'Fast response times', 'Experienced emergency technicians', 'Fully stocked service vehicles', 'Transparent emergency pricing'],
        'symptoms' => ['Complete system failure', 'No heat in freezing temperatures', 'AC out during extreme heat', 'Gas leak concerns', 'Carbon monoxide alarm', 'Electrical burning smell from HVAC'],
        'process' => [
            ['step' => 'Call Our Emergency Line', 'detail' => 'Reach a real person 24/7 who will dispatch help immediately.'],
            ['step' => 'Rapid Response', 'detail' => 'A technician is dispatched to your location as quickly as possible.'],
            ['step' => 'Emergency Diagnosis', 'detail' => 'We identify the problem and determine the safest solution.'],
            ['step' => 'Immediate Resolution', 'detail' => 'We resolve the emergency and restore your comfort and safety.'],
        ],
        'faqs' => [
            ['q' => 'What qualifies as an HVAC emergency?', 'a' => 'Complete system failure in extreme temperatures, gas leaks, carbon monoxide concerns, and electrical issues are all HVAC emergencies. When in doubt, call us.'],
            ['q' => 'Is there an extra charge for emergency service?', 'a' => 'Emergency calls may have a premium rate, but we always provide upfront pricing before beginning any work.'],
        ],
        'seoText' => '24/7 emergency HVAC service in Tulsa, OK. Okie Heating and Cooling provides fast emergency heating and air conditioning repair when you need it most.',
    ],
    [
        'slug' => 'commercial-hvac', 'title' => 'Commercial HVAC', 'shortTitle' => 'Commercial', 'category' => 'commercial', 'icon' => 'building', 'formValue' => 'commercial',
        'heroHeadline' => 'Commercial HVAC Services in Tulsa, OK',
        'heroSubheadline' => 'Keep your business comfortable and productive with reliable commercial HVAC solutions from Okie Heating and Cooling.',
        'description' => 'From offices and retail spaces to restaurants and warehouses, we provide commercial HVAC installation, repair, and maintenance that keeps your business running smoothly.',
        'benefits' => ['Commercial-grade solutions', 'Minimize business downtime', 'Preventive maintenance plans', 'Energy-efficient upgrades', 'Code-compliant installations'],
        'symptoms' => ['Uncomfortable employees or customers', 'High commercial energy costs', 'Aging commercial HVAC equipment', 'Need for a new build HVAC system', 'Compliance or inspection concerns'],
        'process' => [
            ['step' => 'Business Assessment', 'detail' => 'We evaluate your commercial space and HVAC needs.'],
            ['step' => 'Custom Solution', 'detail' => 'We design a system or service plan tailored to your business.'],
            ['step' => 'Professional Execution', 'detail' => 'Work is scheduled to minimize disruption to your operations.'],
            ['step' => 'Ongoing Partnership', 'detail' => 'We provide maintenance plans to keep your system reliable.'],
        ],
        'faqs' => [
            ['q' => 'Do you service all types of commercial buildings?', 'a' => 'Yes, we service offices, retail stores, restaurants, warehouses, churches, and more. Contact us to discuss your specific needs.'],
        ],
        'seoText' => 'Commercial HVAC services in Tulsa, OK. Okie Heating and Cooling provides installation, repair, and maintenance for businesses throughout the Tulsa metro area.',
    ],
];

const SERVICE_CATEGORIES = [
    'cooling' => 'Cooling Services',
    'heating' => 'Heating Services',
    'air-quality' => 'Air Quality',
    'controls' => 'Controls & Thermostats',
    'ductwork' => 'Ductwork',
    'emergency' => 'Emergency',
    'commercial' => 'Commercial',
];

// ---------------------------------------------------------------------------
// Service areas
// ---------------------------------------------------------------------------
const SERVICE_AREAS = [
    ['slug' => 'tulsa', 'name' => 'Tulsa', 'zip' => '74101-74199',
        'description' => "As Tulsa's premier HVAC company, we're proud to serve homeowners and businesses across Tulsa with fast, reliable heating and cooling services.",
        'highlights' => ['Same-day service available', 'Centrally located for fast response', 'Serving all Tulsa neighborhoods'],
        'seoText' => 'Okie Heating and Cooling proudly serves Tulsa, Oklahoma with professional HVAC services including AC repair, heating repair, furnace installation, and 24/7 emergency service. As a locally owned and operated company, we understand the unique climate challenges Tulsa homeowners face — from scorching summers to unpredictable winter weather. Our certified technicians are available for same-day service across all Tulsa neighborhoods, from midtown to south Tulsa, providing honest pricing and quality workmanship you can trust.'],
    ['slug' => 'broken-arrow', 'name' => 'Broken Arrow', 'zip' => '74011-74014',
        'description' => 'Broken Arrow families trust Okie Heating and Cooling for dependable HVAC repair, installation, and maintenance with fast response times.',
        'highlights' => ['Fast service from nearby Tulsa', 'Residential and commercial HVAC', 'Trusted by Broken Arrow families'],
        'seoText' => 'Need HVAC service in Broken Arrow, Oklahoma? Okie Heating and Cooling provides professional air conditioning repair, heating services, furnace installation, and emergency HVAC across Broken Arrow. Our proximity to Broken Arrow means faster response times and same-day availability for most services.'],
    ['slug' => 'owasso', 'name' => 'Owasso', 'zip' => '74055',
        'description' => 'Owasso homeowners and businesses count on Okie Heating and Cooling for expert HVAC services, from routine maintenance to emergency repairs.',
        'highlights' => ['Serving Owasso and north Tulsa county', 'All heating and cooling services', 'Emergency response available'],
        'seoText' => 'Professional HVAC services in Owasso, Oklahoma from Okie Heating and Cooling. We provide AC repair, heating installation, furnace maintenance, and 24/7 emergency service to Owasso homes and businesses.'],
    ['slug' => 'bixby', 'name' => 'Bixby', 'zip' => '74008',
        'description' => 'Bixby residents rely on Okie Heating and Cooling for high-quality HVAC solutions, from new system installations to quick repairs.',
        'highlights' => ['Full HVAC services in Bixby', 'Growing community expertise', 'Quality installations and repairs'],
        'seoText' => 'Okie Heating and Cooling provides trusted HVAC services in Bixby, Oklahoma including AC repair, heating repair, new system installation, and preventive maintenance plans.'],
    ['slug' => 'jenks', 'name' => 'Jenks', 'zip' => '74037',
        'description' => 'From the Riverwalk to your doorstep — Okie Heating and Cooling brings fast, professional HVAC service to Jenks homeowners.',
        'highlights' => ['Quick service from Tulsa HQ', 'Residential HVAC specialists', 'Maintenance plans available'],
        'seoText' => 'HVAC repair, installation, and maintenance in Jenks, Oklahoma. Okie Heating and Cooling serves the Jenks community with professional heating and air conditioning services.'],
    ['slug' => 'sand-springs', 'name' => 'Sand Springs', 'zip' => '74063',
        'description' => "Sand Springs families trust us for honest HVAC work. From AC tune-ups to full system replacements, we've got you covered.",
        'highlights' => ['Serving west Tulsa county', 'Honest pricing and quality work', 'All makes and models serviced'],
        'seoText' => 'Reliable HVAC services in Sand Springs, Oklahoma. Okie Heating and Cooling provides heating and cooling repair, installation, and maintenance to Sand Springs homes and businesses.'],
    ['slug' => 'sapulpa', 'name' => 'Sapulpa', 'zip' => '74066',
        'description' => 'Sapulpa homeowners count on Okie Heating and Cooling for affordable, professional HVAC services delivered with integrity.',
        'highlights' => ['Affordable HVAC services', 'Experienced Sapulpa technicians', 'Emergency service available'],
        'seoText' => 'Okie Heating and Cooling serves Sapulpa, Oklahoma with professional HVAC services. From AC repair to furnace installation, we keep Sapulpa homes comfortable year-round.'],
    ['slug' => 'glenpool', 'name' => 'Glenpool', 'zip' => '74033',
        'description' => 'Glenpool residents enjoy fast, friendly HVAC service from Okie Heating and Cooling — your local heating and cooling experts.',
        'highlights' => ['Serving south Tulsa county', 'Friendly, professional service', 'Full range of HVAC solutions'],
        'seoText' => 'Professional HVAC services in Glenpool, Oklahoma from Okie Heating and Cooling. We provide air conditioning repair, heating services, and new system installations for Glenpool families.'],
];

// ---------------------------------------------------------------------------
// Reviews / testimonials
// ---------------------------------------------------------------------------
const HOME_TESTIMONIALS = [
    ['customer_name' => 'Sarah M.', 'location' => 'Tulsa, OK', 'rating' => 5, 'verified' => true, 'text' => 'Our AC went out on the hottest day of the year. Okie Heating and Cooling had a technician at our door within two hours and had us cool again by dinner. Incredible service and fair pricing.'],
    ['customer_name' => 'James T.', 'location' => 'Broken Arrow, OK', 'rating' => 5, 'verified' => true, 'text' => 'We needed a whole new furnace installed. They gave us multiple options, explained everything clearly, and the installation was clean and professional. Highly recommend to anyone in the Tulsa area.'],
    ['customer_name' => 'Lisa R.', 'location' => 'Owasso, OK', 'rating' => 5, 'verified' => true, 'text' => "I've used Okie Heating and Cooling for annual maintenance for three years now. They're always on time, professional, and thorough. My system runs great because of them."],
    ['customer_name' => 'Mike D.', 'location' => 'Jenks, OK', 'rating' => 5, 'verified' => true, 'text' => 'Emergency call at 11pm on a freezing night — they answered and had someone out fast. The technician was professional and got our heat back on quickly. These guys are the real deal.'],
];

const REVIEWS = [
    ['customer_name' => 'Danica Jones', 'location' => 'Local Guide · 19 reviews', 'rating' => 5, 'verified' => true, 'text' => 'Great service. My HVAC at the house I bought is very old, and they helped get everything in working order so it could safely function. Very happy my colleague referred them.'],
    ['customer_name' => 'Yongwei Shan', 'location' => 'Local Guide · 25 reviews', 'rating' => 5, 'verified' => true, 'text' => 'I have been using OKIE Heating and Cooling for slightly over a year. They have always been very good at communicating with their clients. I highly recommend Khai. He is super knowledgeable and knows what he is doing.'],
    ['customer_name' => 'John Brown', 'location' => '5 reviews', 'rating' => 5, 'verified' => true, 'text' => 'Company showed up on time. Knew what the problem was and fixed it very fast. Price was very fair. Will be calling them again. Thank you for being an honest company.'],
    ['customer_name' => 'Kevin Saechao', 'location' => '3 reviews', 'rating' => 5, 'verified' => true, 'text' => 'Awesome people, they are friendly and very knowledgeable. Highly recommend for reliable services.'],
    ['customer_name' => 'Carlton Welch II', 'location' => '11 reviews', 'rating' => 5, 'verified' => true, 'text' => 'These guys do great work, very knowledgeable and experienced. I will use them again.'],
    ['customer_name' => 'Zoey Welch', 'location' => '2 reviews', 'rating' => 5, 'verified' => true, 'text' => 'Very professional and great communication. Highly recommend this company!'],
    ['customer_name' => 'Shane Cornelius', 'location' => '3 reviews', 'rating' => 5, 'verified' => true, 'text' => 'Great guys, very friendly, honest and dependable. Will get you up and running in no time.'],
    ['customer_name' => 'Pau Tuang', 'location' => '1 review', 'rating' => 5, 'verified' => true, 'text' => 'Knowledgeable and professional. Also, take time to explain the issue and how to prevent it in the future. Would hire them again!'],
    ['customer_name' => 'Grace Sian H', 'location' => '2 reviews', 'rating' => 5, 'verified' => true, 'text' => 'Very good service and get the job done well. Very professional.'],
    ['customer_name' => 'Shelbie Raney', 'location' => '1 review', 'rating' => 5, 'verified' => true, 'text' => 'Great response time and excellent work! Very friendly and will answer any questions you have.'],
    ['customer_name' => 'Tom Polson', 'location' => '14 reviews', 'rating' => 5, 'verified' => true, 'text' => 'Perfect service.'],
];

const HOME_FAQS = [
    ['q' => 'What areas do you serve?', 'a' => 'We serve Tulsa and the surrounding metro area including Broken Arrow, Owasso, Bixby, Jenks, Sand Springs, Sapulpa, Glenpool, and nearby communities.'],
    ['q' => 'Do you offer 24/7 emergency HVAC service?', 'a' => 'Yes! We have technicians available around the clock for heating and cooling emergencies. Call us anytime for immediate help.'],
    ['q' => 'How quickly can you get to my home?', 'a' => 'For most routine service calls, we offer same-day or next-day appointments. For emergencies, we dispatch as quickly as possible, often within a few hours.'],
    ['q' => 'Do you provide free estimates for new installations?', 'a' => 'Yes, we provide free in-home consultations and estimates for all new HVAC system installations.'],
    ['q' => 'What brands do you service?', 'a' => 'We service all major HVAC brands including Carrier, Trane, Lennox, Rheem, Goodman, Daikin, York, and many more.'],
    ['q' => 'Do you offer financing?', 'a' => 'Yes, we offer flexible financing options to help make new system installations and major repairs affordable.'],
];

// ---------------------------------------------------------------------------
// Brands serviced (matches the list already published in HOME_FAQS/services)
// ---------------------------------------------------------------------------
const BRANDS_SERVICED = ['Carrier', 'Trane', 'Lennox', 'Rheem', 'Goodman', 'Daikin', 'York'];

// ---------------------------------------------------------------------------
// Financing specials — placeholder entries until real offers are supplied.
// Expired entries are filtered out automatically by active_financing_specials().
// ---------------------------------------------------------------------------
const FINANCING_SPECIALS = [
    ['title' => '{{SPECIAL_1_TITLE}}', 'price' => '{{SPECIAL_1_PRICE}}', 'expires' => '{{SPECIAL_1_EXPIRY}}'],
    ['title' => '{{SPECIAL_2_TITLE}}', 'price' => '{{SPECIAL_2_PRICE}}', 'expires' => '{{SPECIAL_2_EXPIRY}}'],
];

/** Specials with a parseable, non-past expiry date. Unparseable placeholder dates are skipped. */
function active_financing_specials(): array
{
    $today = date('Y-m-d');
    return array_values(array_filter(FINANCING_SPECIALS, function ($s) use ($today) {
        $ts = strtotime($s['expires']);
        return $ts !== false && date('Y-m-d', $ts) >= $today;
    }));
}

function get_service_by_slug(string $slug): ?array
{
    foreach (SERVICES as $s) {
        if ($s['slug'] === $slug) {
            return $s;
        }
    }
    return null;
}

function get_area_by_slug(string $slug): ?array
{
    foreach (SERVICE_AREAS as $a) {
        if ($a['slug'] === $slug) {
            return $a;
        }
    }
    return null;
}
