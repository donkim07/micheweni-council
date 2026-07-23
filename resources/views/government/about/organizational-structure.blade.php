@extends('government.layouts.app')

@section('title', __('Organization Structure'))

@section('styles')
<style>
    .page-hero {
        background: linear-gradient(rgba(20, 78, 115, 0.8), rgba(52, 152, 219, 0.8)), url('/images/government/org-structure-bg.jpg');
        background-size: cover;
        background-position: center;
        color: white;
        padding: 60px 0;
    }
    
    .org-chart {
        padding: 30px 0;
    }
    
    .org-chart-tree {
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    
    .org-level {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        width: 100%;
        margin-bottom: 30px;
    }
    
    .org-box {
        position: relative;
        padding: 15px;
        margin: 10px;
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        min-width: 200px;
        text-align: center;
        border-left: 4px solid var(--primary);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .org-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    }
    
    .org-box.main {
        background-color: var(--primary);
        color: white;
        border-left: none;
        max-width: 300px;
    }
    
    .org-box.department {
        border-left: 4px solid var(--accent);
    }
    
    .org-box.unit {
        border-left: 4px solid var(--secondary);
        max-width: 280px;
    }
    
    .org-box.unit-wide {
        border-left: 4px solid var(--secondary);
        max-width: 450px;
    }
    
    .org-box.division {
        border-left: 4px solid var(--success);
    }
    
    .org-title {
        font-weight: 700;
        margin-bottom: 5px;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .org-position {
        font-size: 0.85rem;
        margin-bottom: 0;
    }
    
    .org-connector {
        width: 2px;
        height: 30px;
        background-color: #ccc;
        margin: 0 auto;
    }
    
    .department-card {
        height: 100%;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        transition: transform 0.3s ease;
        border: none;
    }
    
    .department-card:hover {
        transform: translateY(-5px);
    }
    
    .department-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 15px;
        background-color: rgba(20, 78, 115, 0.1);
        color: var(--primary);
        font-size: 1.5rem;
    }
    
    .department-title {
        font-weight: 600;
        color: var(--primary);
        margin-bottom: 10px;
    }
    
    .department-manager {
        font-size: 0.9rem;
        color: var(--dark);
        margin-bottom: 15px;
    }
    
    .department-info {
        font-size: 0.95rem;
        line-height: 1.6;
    }
    
    .org-level-flex {
        display: flex;
        justify-content: space-around;
        width: 100%;
        margin-bottom: 30px;
    }
    
    .org-column {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 30px;
    }
    
    .org-column-left {
        align-items: flex-end;
        flex: 1;
    }
    
    .org-column-right {
        align-items: flex-start;
        flex: 1;
    }
    
    .org-column-center {
        align-items: center;
        flex: 2;
    }
    
    .org-divisions {
        display: flex;
        justify-content: space-between;
        width: 100%;
        margin-top: 20px;
    }
    
    .org-division-box {
        flex: 1;
        margin: 0 10px;
    }
    
    .vertical-line {
        width: 2px;
        background-color: #ccc;
        position: absolute;
        top: 0;
        bottom: 0;
    }
    
    .horizontal-line {
        height: 2px;
        background-color: #ccc;
        position: absolute;
    }
    
    .unit-box-wrapper {
        display: flex;
        justify-content: flex-end;
        width: 100%;
    }
    
    .unit-box-wrapper-right {
        display: flex;
        justify-content: flex-start;
        width: 100%;
    }
  
    
    /* Custom counter styles for shehia list */
    .shehia-list {
        list-style: none;
        counter-reset: shehia-counter;
        padding-left: 0;
    }
    
    .shehia-list li {
        counter-increment: shehia-counter;
        position: relative;
        padding: 0.75rem 1.25rem;
        margin-bottom: -1px;
        background-color: #fff;
        border: 1px solid rgba(0,0,0,.125);
    }
    
    .shehia-list li::before {
        content: counter(shehia-counter) ". ";
        font-weight: bold;
        margin-right: 5px;
    }
    
    .shehia-list-second {
        list-style: none;
        counter-reset: shehia-counter 13;
        padding-left: 0;
    }
    
    .shehia-list-second li {
        counter-increment: shehia-counter;
        position: relative;
        padding: 0.75rem 1.25rem;
        margin-bottom: -1px;
        background-color: #fff;
        border: 1px solid rgba(0,0,0,.125);
    }
    
    .shehia-list-second li::before {
        content: counter(shehia-counter) ". ";
        font-weight: bold;
        margin-right: 5px;
    }
    
    /* Mobile responsiveness improvements */
    @media (max-width: 767.98px) {
        .org-chart .container {
            max-width: 100%;
            padding: 0 10px;
        }
        
        .org-box {
            min-width: auto;
            width: 100%;
            margin: 5px 0;
        }
        
        .org-box.unit-wide {
            max-width: 100%;
        }
        
        .vertical-line {
            left: 50%;
            transform: translateX(-50%);
        }
        
        .horizontal-line {
            width: 20px !important;
        }
        
        .unit-box-wrapper, .unit-box-wrapper-right {
            justify-content: center;
        }
        
        .org-title {
            font-size: 0.8rem;
        }
        
        .org-position {
            font-size: 0.75rem;
        }
        
        .col-mobile-12 {
            flex: 0 0 100%;
            max-width: 100%;
        }
        
        .mobile-mb-3 {
            margin-bottom: 1rem !important;
        }
        
        .mobile-mt-3 {
            margin-top: 1rem !important;
        }
        
        .mobile-center {
            text-align: center !important;
        }
    }
</style>
@endsection

@section('content')
<!-- Page Hero -->
<div class="page-hero">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="{{ url('/government') }}" class="text-white">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('/government/about') }}" class="text-white">About</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">Organization Structure</li>
                    </ol>
                </nav>
                
                <h1 class="display-4 fw-bold mb-3">Organization Structure</h1>
                <p class="lead mb-4">Understanding the structure and organization of the Micheweni District.</p>
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="container py-5">
    <div class="row mb-5">
        <div class="col-lg-8 mx-auto">
            <h2 class="section-title text-center mb-4">Our Organization Structure</h2>
            <p class="text-center mb-5">
                The Micheweni District Council is structured to effectively serve our community with clear lines of accountability, 
                specialized departments to address different needs, and a focus on collaborative governance. This organization
                structure was approved by the Revolutionary Government of Zanzibar in August 2024.
            </p>
        </div>
    </div>
    
    <!-- Organizational Chart -->
    <div class="org-chart mb-5">
        <div class="container">
            <!-- Level 1: District Commissioner (Mkuu wa Wilaya) -->
            <div class="row justify-content-center mb-4">
                <div class="col-md-6 col-lg-4 col-mobile-12">
                    <div class="org-box main mx-auto" data-aos="fade-down">
                        <h3 class="org-title" translate="no">MKUU WA WILAYA</h3>
                        <p class="org-position">District Commissioner</p>
                    </div>
                </div>
            </div>
            
            <div class="org-connector"></div>
            
            <!-- Level 2: District Administrative Secretary (Katibu Tawala Wilaya) -->
            <div class="row justify-content-center mb-4">
                <div class="col-md-6 col-lg-4 col-mobile-12">
                    <div class="org-box mx-auto" data-aos="fade-up">
                        <h3 class="org-title" translate="no">KATIBU TAWALA WILAYA</h3>
                        <p class="org-position">District Administrative Secretary</p>
                </div>
                </div>
            </div>
            
            <div class="org-connector"></div>
            
            <!-- Level 3: Units Row 1 (Vitengo) -->
            <div class="row justify-content-center mb-4">
                <div class="col-md-5 col-mobile-12 position-relative d-flex justify-content-center mobile-mb-3" style="padding-left: 7em;">
                    <div style="position: relative; width: 100%; max-width: 280px;">
                        <!-- Horizontal connector to center -->
                        <!-- <div class="horizontal-line" style="right: -15px; top: 50%; width: 15px;"></div> -->
                        <div class="org-box unit w-100" data-aos="fade-right">
                            <h3 class="org-title" translate="no">KITENGO CHA FEDHA</h3>
                            <p class="org-position">Finance Unit</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-2 d-md-flex d-none justify-content-center position-relative">
                    <!-- Vertical connector -->
                    <div class="vertical-line"></div>
                </div>
                
                <div class="col-md-5 col-mobile-12 position-relative d-flex justify-content-center">
                    <div style="position: relative; width: 100%; max-width: 450px;">
                        <!-- Horizontal connector to center -->
                        <!-- <div class="horizontal-line" style="left: -15px; top: 50%; width: 15px;"></div> -->
                        <div class="org-box unit-wide w-100" data-aos="fade-left">
                            <h3 class="org-title" translate="no">KITENGO CHA HABARI NA UHUSIANO TEHAMA NA ELIMU KWA UMMA</h3>
                            <p class="org-position">Information, Communication, ICT & Public Education Unit</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Level 4: Units Row 2 (Vitengo) -->
            <div class="row justify-content-center mb-4">
                <div class="col-md-5 col-mobile-12 position-relative d-flex justify-content-center mobile-mb-3 pe-lg-3" style="padding-left: 7em;">
                    <div style="position: relative; width: 100%; max-width: 280px;">
                        <!-- Horizontal connector to center -->
                        <!-- <div class="horizontal-line" style="right: -15px; top: 50%; width: 15px;"></div> -->
                        <div class="org-box unit w-100" data-aos="fade-right">
                            <h3 class="org-title" translate="no">KITENGO CHA MANUNUZI</h3>
                            <p class="org-position">Procurement Unit</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-2 d-md-flex d-none justify-content-center position-relative">
                    <!-- Vertical connector -->
                    <div class="vertical-line"></div>
                </div>
                
                <div class="col-md-5 col-mobile-12 position-relative flex-column align-items-center">
                    <div style="position: relative; width: 100%; max-width: 280px;">
                        <!-- Horizontal connector to center -->
                        <!-- <div class="horizontal-line" style="left: -15px; top: 50%; width: 15px;"></div> -->
                        <div class="org-box unit w-100 mb-4" data-aos="fade-left">
                            <h3 class="org-title" translate="no">KITENGO CHA SHERIA</h3>
                            <p class="org-position">Legal Unit</p>
                        </div>
                </div>
                
                    <div style="position: relative; width: 100%; max-width: 280px;">
                        <!-- Horizontal connector to center -->
                        <!-- <div class="horizontal-line" style="left: -15px; top: 50%; width: 15px;"></div> -->
                        <div class="org-box unit w-100" data-aos="fade-left">
                            <h3 class="org-title" translate="no">KITENGO CHA URATIBU WA SHEHIA</h3>
                            <p class="org-position">Shehia Coordination Unit</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="org-connector"></div>
            
            <!-- Level 5: Divisions (Divisheni) -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="d-flex justify-content-between flex-wrap">
                        <div class="org-box division m-2" style="flex: 1; min-width: 250px;" data-aos="fade-up">
                            <h3 class="org-title" translate="no">DIVISHENI YA RASILIMALI WATU NA UTAWALA</h3>
                            <p class="org-position">Human Resources & Administration Division</p>
                </div>
                
                        <div class="org-box division m-2" style="flex: 1; min-width: 250px;" data-aos="fade-up">
                            <h3 class="org-title" translate="no">DIVISHENI YA MIPANGO NA TAKWIMU</h3>
                            <p class="org-position">Planning & Statistics Division</p>
                </div>
                
                        <div class="org-box division m-2" style="flex: 1; min-width: 250px;" data-aos="fade-up">
                            <h3 class="org-title" translate="no">DIVISHENI YA URATIBU WA SEKTA</h3>
                            <p class="org-position">Sector Coordination Division</p>
                </div>
                
                        <div class="org-box division m-2" style="flex: 1; min-width: 250px;" data-aos="fade-up">
                            <h3 class="org-title" translate="no">DIVISHENI YA MASUALA MTAMBUKA NA HUDUMA ZA JAMII</h3>
                            <p class="org-position">Cross-cutting Issues & Community Services Division</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
   <!-- Key Divisions & Units -->
    <div class="row mb-5">
        <div class="col-12">
            <h2 class="section-title text-center mb-5">Key Divisions & Units</h2>
        </div>
        
        <!-- Divisions -->
        <div class="col-md-6 col-lg-3 mb-4" data-aos="fade-up">
            <div class="card department-card h-100">
                <div class="card-body p-4">
                    <div class="department-icon">
                        <i class="fas fa-users-cog"></i>
                    </div>
                    <h3 class="department-title" >Rasilimali Watu na Utawala</h3>
                    <p class="department-info">
                        Responsible for human resources management, administration, staff development, and maintaining office records and resources.
                    </p>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 col-lg-3 mb-4" data-aos="fade-up" data-aos-delay="100">
            <div class="card department-card h-100">
                <div class="card-body p-4">
                    <div class="department-icon">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <h3 class="department-title" >Mipango na Takwimu</h3>
                    <p class="department-info">
                        Handles district planning, budget preparation, project monitoring, evaluation, research, and statistical data management.
                    </p>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 col-lg-3 mb-4" data-aos="fade-up" data-aos-delay="200">
            <div class="card department-card h-100">
                <div class="card-body p-4">
                    <div class="department-icon">
                        <i class="fas fa-sitemap"></i>
                    </div>
                    <h3 class="department-title" >Uratibu wa Sekta</h3>
                    <p class="department-info">
                        Coordinates sector policies and operations, monitors implementation of sectoral plans, and prepares reports on sector activities.
                    </p>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 col-lg-3 mb-4" data-aos="fade-up" data-aos-delay="300">
            <div class="card department-card h-100">
                <div class="card-body p-4">
                    <div class="department-icon">
                        <i class="fas fa-hands-helping"></i>
                    </div>
                    <h3 class="department-title" >Masuala Mtambuka na Huduma za Jamii</h3>
                    <p class="department-info">
                        Addresses cross-cutting issues including gender, HIV/AIDS, drug abuse, environment, and community services provision.
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Units -->
        <div class="col-md-6 col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="400">
            <div class="card department-card h-100">
                <div class="card-body p-4">
                    <div class="department-icon">
                        <i class="fas fa-coins"></i>
                    </div>
                    <h3 class="department-title" >Kitengo cha Fedha</h3>
                    <p class="department-info">
                        Manages district finances, payments, revenue collection, financial reporting, and accounting records.
                    </p>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="500">
            <div class="card department-card h-100">
                <div class="card-body p-4">
                    <div class="department-icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <h3 class="department-title" >Kitengo cha Manunuzi</h3>
                    <p class="department-info">
                        Handles procurement planning, tender management, asset registry, and supply chain management according to public procurement laws.
                    </p>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 col-lg-4 mb-4" data-aos="fade-up" data-aos-delay="600">
            <div class="card department-card h-100">
                <div class="card-body p-4">
                    <div class="department-icon">
                        <i class="fas fa-balance-scale"></i>
                    </div>
                    <h3 class="department-title" >Kitengo cha Sheria</h3>
                    <p class="department-info">
                        Provides legal advice, assists with legal interpretation of laws and contracts, and prepares legal documents for the district.
                    </p>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 col-lg-6 mb-4" data-aos="fade-up" data-aos-delay="700">
            <div class="card department-card h-100">
                <div class="card-body p-4">
                    <div class="department-icon">
                        <i class="fas fa-broadcast-tower"></i>
                    </div>
                    <h3 class="department-title" >Kitengo cha Habari na Uhusiano TEHAMA na Elimu kwa Umma</h3>
                    <p class="department-info">
                        Manages information systems, communications, technology services, media relations, and public education initiatives.
                    </p>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 col-lg-6 mb-4" data-aos="fade-up" data-aos-delay="800">
            <div class="card department-card h-100">
                <div class="card-body p-4">
                    <div class="department-icon">
                        <i class="fas fa-map-marked-alt"></i>
                    </div>
                    <h3 class="department-title" >Kitengo cha Uratibu wa Shehia</h3>
                    <p class="department-info">
                        Coordinates activities at Shehia (local community) level, follows up on guidelines and directives, monitors resident information, and provides technical advice.
                    </p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Administrative Structure -->
    <div class="my-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                        <h3 class="section-title text-center mb-5">Administrative Structure</h3>
                        
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="card h-100">
                                    <div class="card-header bg-light">
                                        <h4 class="mb-0">Wards (8)</h4>
                                    </div>
                                    <div class="card-body" translate="no">
                                        <ol class="list-group list-group-flush list-group-numbered">
                                            <li class="list-group-item">Chimba</li>
                                            <li class="list-group-item">Kiuyu Maziwa Ng'ombe</li>
                                            <li class="list-group-item">Konde</li>
                                            <li class="list-group-item">Micheweni</li>
                                            <li class="list-group-item">Msuka</li>
                                            <li class="list-group-item">Sizini</li>
                                            <li class="list-group-item">Tumbe</li>
                                            <li class="list-group-item">Wingwi</li>
                                        </ol>
                                    </div>
                                </div>
                    </div>
                    
                            <div class="col-md-6">
                                <div class="card h-100">
                                    <div class="card-header bg-light">
                                        <h4 class="mb-0">Shehias (25)</h4>
                                    </div>
                                    <div class="card-body" translate="no">
                                        <div class="row">
                                            <div class="col-md-6" >
                                                <ul class="shehia-list">
                                                    <li>Maziwang'ombe</li>
                                                    <li>Shanake</li>
                                                    <li>Kiuyu mbuyuni</li>
                                                    <li>Micheweni</li>
                                                    <li>Chamboni</li>
                                                    <li>Majenzi</li>
                                                    <li>Mjiniwingwi</li>
                                                    <li>Shumba mjini</li>
                                                    <li>Wingwi mapofu</li>
                                                    <li>Mtemani</li>
                                                    <li>Wingwi Njugni</li>
                                                    <li>Sizini</li>
                                                    <li>Tumbe mashariki</li>
                                                </ul>
                                            </div>
                                            <div class="col-md-6">
                                                <ul class="shehia-list-second">
                                                    <li>Tumbe magharibi</li>
                                                    <li>Chimba</li>
                                                    <li>Shumba vyamboni</li>
                                                    <li>Kinowe</li>
                                                    <li>Konde</li>
                                                    <li>Msuka mashariki</li>
                                                    <li>Msuka magharibi</li>
                                                    <li>Kifundi</li>
                                                    <li>Kipange</li>
                                                    <li>Tondooni</li>
                                                    <li>Makangale</li>
                                                    <li>Mihogoni</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                    
                        <div class="mt-4">
                            <p class="mb-3">
                                <strong>Population and Demographics:</strong>
                            </p>
                            <ul class="list-group">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Male Population
                                    <span class="badge bg-primary rounded-pill">59,555</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Female Population
                                    <span class="badge bg-primary rounded-pill">63,824</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <strong>Total Population</strong>
                                    <span class="badge bg-primary rounded-pill">123,379</span>
                                </li>
                        </ul>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 