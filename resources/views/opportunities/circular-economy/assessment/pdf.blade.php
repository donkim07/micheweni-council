<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Assessment Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 2px solid #ddd;
        }
        .header h1 {
            color: #2c3e50;
            margin-bottom: 5px;
        }
        .header p {
            color: #7f8c8d;
            font-size: 16px;
            margin-top: 0;
        }
        .score-section {
            background-color: #f9f9f9;
            padding: 20px;
            margin-bottom: 30px;
            border-radius: 5px;
        }
        .score-section h2 {
            margin-top: 0;
            color: #2c3e50;
        }
        .score-box {
            font-size: 48px;
            font-weight: bold;
            text-align: center;
            margin: 20px 0;
        }
        .high-score {
            color: #27ae60;
        }
        .medium-score {
            color: #f39c12;
        }
        .low-score {
            color: #e74c3c;
        }
        .category-score {
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }
        .category-score:last-child {
            border-bottom: none;
        }
        .category-name {
            font-weight: bold;
            display: inline-block;
            width: 60%;
        }
        .category-value {
            display: inline-block;
            width: 30%;
            text-align: right;
            font-weight: bold;
        }
        .recommendations {
            margin-bottom: 30px;
        }
        .recommendation {
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
        }
        .recommendation:last-child {
            border-bottom: none;
        }
        .recommendation h4 {
            margin-bottom: 5px;
            color: #2c3e50;
        }
        .priority-tag {
            display: inline-block;
            padding: 3px 8px;
            font-size: 12px;
            border-radius: 3px;
            margin-bottom: 10px;
        }
        .high-priority {
            background-color: #e74c3c;
            color: white;
        }
        .medium-priority {
            background-color: #f39c12;
            color: white;
        }
        .low-priority {
            background-color: #27ae60;
            color: white;
        }
        .footer {
            text-align: center;
            margin-top: 50px;
            font-size: 12px;
            color: #7f8c8d;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Circular Economy Assessment Report</h1>
            <p>{{ $sectionName }} Assessment</p>
            <p>Generated on: {{ date('F j, Y') }}</p>
        </div>
        
        <div class="score-section">
            <h2>Overall Score</h2>
            <div class="score-box {{ $overallScore >= 80 ? 'high-score' : ($overallScore >= 50 ? 'medium-score' : 'low-score') }}">
                {{ $overallScore }}%
            </div>
            <p>
                @if($overallScore >= 80)
                    Excellent! You're leading in circular economy practices for this area.
                @elseif($overallScore >= 50)
                    Good progress. Some areas could use improvement.
                @else
                    Needs attention. Several areas require improvement.
                @endif
            </p>
        </div>
        
        @if(isset($score['categories']) && count($score['categories']) > 0)
            <h2>Category Scores</h2>
            @foreach($score['categories'] as $category => $categoryScore)
                <div class="category-score">
                    <span class="category-name">{{ ucwords(str_replace('_', ' ', $category)) }}</span>
                    <span class="category-value">{{ $categoryScore }}%</span>
                </div>
            @endforeach
        @endif
        
        <div class="recommendations">
            <h2>Key Recommendations</h2>
            
            @if(isset($recommendations) && count($recommendations) > 0)
                @foreach($recommendations as $recommendation)
                    <div class="recommendation">
                        @php
                            $priorityClass = 'medium-priority';
                            $priorityText = 'Medium Priority';
                            
                            if (isset($recommendation['priority'])) {
                                if ($recommendation['priority'] === 'high') {
                                    $priorityClass = 'high-priority';
                                    $priorityText = 'High Priority';
                                } elseif ($recommendation['priority'] === 'low') {
                                    $priorityClass = 'low-priority';
                                    $priorityText = 'Low Priority';
                                }
                            }
                        @endphp
                        
                        <span class="priority-tag {{ $priorityClass }}">{{ $priorityText }}</span>
                        <h4>{{ $recommendation['title'] }}</h4>
                        <p>{{ $recommendation['description'] }}</p>
                        
                        @if(isset($recommendation['actions']) && count($recommendation['actions']) > 0)
                            <h5>Action Steps:</h5>
                            <ul>
                                @foreach($recommendation['actions'] as $action)
                                    <li>{{ $action }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                @endforeach
            @else
                <p>No specific recommendations available for this assessment.</p>
            @endif
        </div>
        
        <div class="footer">
            <p>This report was generated by the Circular Economy Assessment Tool.</p>
            <p>© {{ date('Y') }} Pemba Waste Portal</p>
        </div>
    </div>
</body>
</html> 