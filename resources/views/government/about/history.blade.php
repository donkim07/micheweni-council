@extends('government.layouts.app')

@section('title', __('History'))

@section('styles')
<style>
    .page-hero {
        background: linear-gradient(rgba(20, 78, 115, 0.8), rgba(52, 152, 219, 0.8)), url('/images/government/history-bg.jpg');
        background-size: cover;
        background-position: center;
        color: white;
        padding: 60px 0;
    }
    
    .timeline {
        position: relative;
        max-width: 1200px;
        margin: 0 auto;
    }
    
    .timeline::after {
        content: '';
        position: absolute;
        width: 6px;
        background-color: var(--primary);
        top: 0;
        bottom: 0;
        left: 50%;
        margin-left: -3px;
        z-index: 1;
    }
    
    .timeline-container {
        padding: 10px 40px;
        position: relative;
        background-color: inherit;
        width: 50%;
    }
    
    .timeline-container::after {
        content: '';
        position: absolute;
        width: 25px;
        height: 25px;
        right: -12px;
        background-color: white;
        border: 4px solid var(--accent);
        top: 15px;
        border-radius: 50%;
        z-index: 2;
    }
    
    .left {
        left: 0;
    }
    
    .right {
        left: 50%;
    }
    
    .left::before {
        content: " ";
        height: 0;
        position: absolute;
        top: 22px;
        width: 0;
        z-index: 1;
        right: 30px;
        border: medium solid white;
        border-width: 10px 0 10px 10px;
        border-color: transparent transparent transparent white;
    }
    
    .right::before {
        content: " ";
        height: 0;
        position: absolute;
        top: 22px;
        width: 0;
        z-index: 1;
        left: 30px;
        border: medium solid white;
        border-width: 10px 10px 10px 0;
        border-color: transparent white transparent transparent;
    }
    
    .right::after {
        left: -12px;
    }
    
    .timeline-content {
        padding: 20px 30px;
        background-color: white;
        position: relative;
        border-radius: 6px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .timeline-year {
        color: var(--primary);
        font-weight: 700;
        font-size: 1.5rem;
        margin-bottom: 10px;
    }
    
    .timeline-title {
        margin-bottom: 15px;
        font-weight: 600;
        color: var(--dark);
    }
    
    .timeline-text {
        line-height: 1.6;
    }
    
    .timeline-image {
        width: 100%;
        border-radius: 6px;
        margin-top: 15px;
        max-height: 200px;
        object-fit: cover;
    }
    
    @media screen and (max-width: 768px) {
        .timeline::after {
            left: 31px;
        }
        
        .timeline-container {
            width: 100%;
            padding-left: 70px;
            padding-right: 25px;
        }
        
        .timeline-container::before {
            left: 60px;
            border-width: 10px 10px 10px 0;
            border-color: transparent white transparent transparent;
        }
        
        .left::after, .right::after {
            left: 19px;
        }
        
        .right {
            left: 0;
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
                        <li class="breadcrumb-item active text-white" aria-current="page">History</li>
                    </ol>
                </nav>
                
                <h1 class="display-4 fw-bold mb-3">Our History</h1>
                <p class="lead mb-4">Explore the rich history and heritage of Micheweni District, from its establishment to the thriving community it is today.</p>
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="container py-5">
    <div class="row mb-5">
        <div class="col-lg-8 mx-auto">
            <h2 class="section-title text-center mb-4">Historical Background of Micheweni District</h2>
            <p class="text-center mb-5">
                Micheweni District Council (MDC) was established under Local Government Act No. 7 of 2014 that emphasizes that local people should participate in the planning processes. The Council has mandated to ensure that community in its area of jurisdiction receives quality social services and economic development activities are fostered to ensure sustainable development. In addition to ensuring sustainable development, the council is also mandated to ensure peace and security in the area.
            </p>
        </div>
    </div>
    
    <div class="timeline">
        <div class="timeline-container left" data-aos="fade-right">
            <div class="timeline-content">
                <div class="timeline-year">2014</div>
                <h3 class="timeline-title">Establishment of MDC</h3>
                <p class="timeline-text">
                    Micheweni District Council was established under Local Government Act No. 7 of 2014, with a mandate to ensure that the local community receives quality social services and fostering economic development activities.
                </p>
            </div>
        </div>
        
        <div class="timeline-container right" data-aos="fade-left">
            <div class="timeline-content">
                <div class="timeline-year">Geographic Location</div>
                <h3 class="timeline-title">Geographical Positioning</h3>
                <p class="timeline-text">
                    Micheweni district is located in the Northern part of Pemba Island with 241 sq. Kilometers and lies between Latitude 455 and 6°30' South of Equator, and Longitude 39° 55° East of Greenwich. It is bordered by Wete district from Southern side and Indian Ocean in both Eastern and Western parts so it the Northern part.
                </p>
            </div>
        </div>
        
        <div class="timeline-container left" data-aos="fade-right">
            <div class="timeline-content">
                <div class="timeline-year">Island Heritage</div>
                <h3 class="timeline-title">Small Islands</h3>
                <p class="timeline-text">
                    Being surrounded by Indian Ocean on its three cardinal points, Micheweni district is endowed with number of small Islands such as Kisiwa Ng'ombe, Kisiwa Mbale, Usubi, Kamate, Mwimo, NjiaUze, Kwa Kombo, Sinawe, Hamisi, and Kijiwa huu.
                </p>
            </div>
        </div>
        
        <div class="timeline-container right" data-aos="fade-left">
            <div class="timeline-content">
                <div class="timeline-year">Administrative</div>
                <h3 class="timeline-title">Regional Context</h3>
                <p class="timeline-text">
                    Micheweni district is one among four districts in Pemba Island, others are Chake, Mkoani, and Wete. Micheweni District Council is responsible for developing and facilitating implementation of the Local Governments policy of Zanzibar in its judiciary area of Micheweni District.
                </p>
            </div>
        </div>
        
        <div class="timeline-container left" data-aos="fade-right">
            <div class="timeline-content">
                <div class="timeline-year">1400s</div>
                <h3 class="timeline-title">Early Settlements</h3>
                <p class="timeline-text">
                    The area now known as Micheweni was first settled by Swahili-speaking peoples who established fishing communities along the coast. These early settlements laid the foundation for what would eventually become Micheweni town.
                </p>
            </div>
        </div>
        
        <div class="timeline-container right" data-aos="fade-left">
            <div class="timeline-content">
                <div class="timeline-year">1700s</div>
                <h3 class="timeline-title">Arab Influence</h3>
                <p class="timeline-text">
                    Arab traders established a stronger presence in Pemba, including Micheweni, leading to increased trade activities and cultural exchange. The production of cloves and other spices began to flourish during this period.
                </p>
            </div>
        </div>
        
        <div class="timeline-container left" data-aos="fade-right">
            <div class="timeline-content">
                <div class="timeline-year">1890</div>
                <h3 class="timeline-title">Colonial Era Begins</h3>
                <p class="timeline-text">
                    Pemba, including Micheweni, came under German colonial rule as part of German East Africa. The colonial administration began to establish more formal governance structures in the region.
                </p>
            </div>
        </div>
        
        <div class="timeline-container right" data-aos="fade-left">
            <div class="timeline-content">
                <div class="timeline-year">1916</div>
                <h3 class="timeline-title">British Administration</h3>
                <p class="timeline-text">
                    Following World War I, Pemba came under British control. The British administration established various administrative centers, including Micheweni, which began to grow as a regional hub.
                </p>
            </div>
        </div>
        
        <div class="timeline-container left" data-aos="fade-right">
            <div class="timeline-content">
                <div class="timeline-year">1963</div>
                <h3 class="timeline-title">Independence of Zanzibar</h3>
                <p class="timeline-text">
                    Zanzibar gained independence from British rule, with Pemba, including Micheweni, becoming part of the newly independent state.
                </p>
            </div>
        </div>
        
        <div class="timeline-container right" data-aos="fade-left">
            <div class="timeline-content">
                <div class="timeline-year">1964</div>
                <h3 class="timeline-title">Zanzibar Revolution</h3>
                <p class="timeline-text">
                    The Zanzibar Revolution led to the overthrow of the Sultan and the establishment of the People's Republic of Zanzibar and Pemba. Later that year, Zanzibar united with Tanganyika to form Tanzania.
                </p>
            </div>
        </div>
        
        <div class="timeline-container left" data-aos="fade-right">
            <div class="timeline-content">
                <div class="timeline-year">1984</div>
                <h3 class="timeline-title">Micheweni District Established</h3>
                <p class="timeline-text">
                    Micheweni was formally established as a district, with its own administrative structure and government offices to better serve the local population.
                </p>
            </div>
        </div>
        
        <div class="timeline-container right" data-aos="fade-left">
            <div class="timeline-content">
                <div class="timeline-year">2000s</div>
                <h3 class="timeline-title">Modern Development</h3>
                <p class="timeline-text">
                    Micheweni District has seen significant infrastructure development, including improved roads, schools, healthcare facilities, and government services, enhancing the quality of life for its residents.
                </p>
            </div>
        </div>
        
        <div class="timeline-container left" data-aos="fade-right">
            <div class="timeline-content">
                <div class="timeline-year">2020</div>
                <h3 class="timeline-title">Sustainable Development Initiatives</h3>
                <p class="timeline-text">
                    Micheweni District has embraced sustainable development initiatives, including waste management projects, renewable energy adoption, and environmental conservation efforts to ensure a better future for generations to come.
                </p>
            </div>
        </div>
        
        <div class="timeline-container right" data-aos="fade-left">
            <div class="timeline-content">
                <div class="timeline-year">Present</div>
                <h3 class="timeline-title">Thriving Community</h3>
                <p class="timeline-text">
                    Today, Micheweni District continues to grow and develop as a thriving community, balancing its rich cultural heritage with modern progress and sustainable development practices.
                </p>
            </div>
        </div>
    </div>
    
    <div class="row mt-5">
        <div class="col-lg-8 mx-auto text-center">
            <h3 class="mb-4">Preserving Our Heritage</h3>
            <p>
                The Micheweni District Council is committed to preserving our rich cultural heritage and historical sites for future generations. 
                We invite all residents and visitors to learn more about our history through our local museums, heritage sites, and cultural events.
            </p>
            <a href="{{ url('/government/contact') }}" class="btn btn-primary mt-3">
                <i class="fas fa-envelope me-2"></i> Contact Us for More Information
            </a>
        </div>
    </div>
</div>
@endsection 