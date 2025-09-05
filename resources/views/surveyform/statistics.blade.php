<!DOCTYPE html>
<html>
<head>
    <title>Survey Statistics Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background: #f0f8ff;
        }
        .card-question {
            border-radius: 12px;
            margin-bottom: 2rem;
            padding: 1.5rem;
            box-shadow: 0 0.3rem 0.6rem rgba(0,0,0,0.1);
        }
        .chart-container {
            position: relative;
            height: 300px;
            margin-bottom: 1rem;
        }
        .toggle-btn {
            margin-bottom: 1rem;
        }
        .collapse-btn {
            cursor: pointer;
            color: #0d6efd;
        }
        .summary-bar .card {
            border-radius: 10px;
            padding: 1rem;
            text-align: center;
        }
        .summary-bar .card h5 {
            margin-bottom: 0.5rem;
        }
        .summary-bar .card p {
            font-size: 1.25rem;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="container py-5">

    <h1 class="text-center mb-5"> Survey  Dashboard</h1>

    @php
        $totalQuestions = $questions->count();
        $totalResponsesAll = $questions->sum(fn($q) => $q->responses->count());
        $averageCompletion = $totalQuestions > 0 ? round($totalResponsesAll / $totalQuestions, 2) : 0;
    @endphp

    
    <div class="row summary-bar mb-5">
        <div class="col-md-4 mb-3">
            <div class="card bg-primary text-white shadow-sm">
                <h5>Total Questions</h5>
                <p>{{ $totalQuestions }}</p>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card bg-success text-white shadow-sm">
                <h5>Total Responses</h5>
                <p>{{ $totalResponsesAll }}</p>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card bg-warning text-dark shadow-sm">
                <h5>Average Completion</h5>
                <p>{{ $averageCompletion }}</p>
            </div>
        </div>
    </div>

    {{-- Questions --}}
    @foreach($questions as $index => $question)
        @php
            $totalResponses = $question->responses->count();
        @endphp

        <div class="card-question">
            <h5>
                {{ $index + 1 }}. {{ $question->question_text }}
                <span class="badge bg-info">{{ $totalResponses }} responses</span>
                <small class="collapse-btn float-end" onclick="toggleCollapse({{ $index }})">[Collapse/Expand]</small>
            </h5>

            <div id="question-body-{{ $index }}">
                @if(in_array($question->type_of_question, ['multiple_choice', 'checkbox']))
                    <button class="btn btn-sm btn-outline-primary toggle-btn" onclick="toggleChart({{ $index }})">Toggle Chart</button>
                    <div class="chart-container">
                        <canvas id="chart-{{ $index }}"></canvas>
                    </div>

                    <ul class="list-group mb-3">
                        @foreach($question->choices as $choice)
                            @php
                                $count = $choice->responses->count();
                                $percent = $totalResponses > 0 ? round(($count / $totalResponses) * 100, 2) : 0;
                                $color = $percent >= 70 ? 'success' : ($percent >= 40 ? 'warning' : 'danger');
                            @endphp
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $choice->choice_text }}
                                <span class="badge bg-{{ $color }}">{{ $count }} ({{ $percent }}%)</span>
                            </li>
                        @endforeach
                    </ul>

                    <script>
                        (function() {
                            const ctx = document.getElementById('chart-{{ $index }}').getContext('2d');
                            const labels = [
                                @foreach($question->choices as $choice)
                                    "{{ $choice->choice_text }}",
                                @endforeach
                            ];
                            const data = [
                                @foreach($question->choices as $choice)
                                    {{ $choice->responses->count() }},
                                @endforeach
                            ];

                            const colors = [
                                'rgba(54, 162, 235, 0.6)',
                                'rgba(255, 99, 132, 0.6)',
                                'rgba(255, 206, 86, 0.6)',
                                'rgba(75, 192, 192, 0.6)',
                                'rgba(153, 102, 255, 0.6)',
                                'rgba(255, 159, 64, 0.6)'
                            ];

                            window['chartObj{{ $index }}'] = new Chart(ctx, {
                                type: 'bar',
                                data: {
                                    labels: labels,
                                    datasets: [{
                                        label: 'Responses',
                                        data: data,
                                        backgroundColor: colors,
                                        borderColor: 'rgba(0,0,0,0.2)',
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    plugins: {
                                        legend: { display: false },
                                        tooltip: {
                                            callbacks: {
                                                label: function(context) {
                                                    const total = {{ $totalResponses }};
                                                    const count = context.raw;
                                                    const percent = total > 0 ? (count / total * 100).toFixed(2) : 0;
                                                    return count + ' responses (' + percent + '%)';
                                                }
                                            }
                                        }
                                    },
                                    scales: {
                                        y: {
                                            beginAtZero: true,
                                            suggestedMax: {{ max($question->choices->pluck('responses')->map(fn($r)=>$r->count())->toArray()) + 1 }}
                                        }
                                    }
                                }
                            });
                        })();
                    </script>

                @elseif($question->type_of_question === 'text')
                    <ul class="list-group mt-3">
                        @forelse($question->responses as $response)
                            <li class="list-group-item">{{ $response->text_answer }}</li>
                        @empty
                            <li class="list-group-item text-muted">No responses yet</li>
                        @endforelse
                    </ul>
                @endif
            </div>
        </div>
    @endforeach
</div>

<script>
function toggleChart(index) {
    const chart = window['chartObj' + index];
    chart.config.type = chart.config.type === 'bar' ? 'pie' : 'bar';
    chart.update();
}

function toggleCollapse(index) {
    const body = document.getElementById('question-body-' + index);
    body.style.display = body.style.display === 'none' ? 'block' : 'none';
}
</script>

</body>
</html>
