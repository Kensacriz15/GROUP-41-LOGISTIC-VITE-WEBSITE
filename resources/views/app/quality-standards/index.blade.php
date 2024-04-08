@extends('layouts/layoutMaster')
<script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"></script>
@section('content')
<div class="card">
    <div class="card-header">
        <h1>Quality Standards</h1>
    </div>
    <div class="card-body">
        <ul class="nav nav-tabs" id="qualityTabs" role="tablist">
            @forelse ($qualityStandards as $index => $qualityStandard)
                <li class="nav-item">
                    <a class="nav-link {{ $index == 0 ? 'active' : '' }}" id="tab-{{ $index + 1 }}" data-toggle="tab" href="#content-{{ $index + 1 }}" role="tab">{{ $qualityStandard->name }}</a>
                </li>
            @empty
                <li class="nav-item">
                    <a class="nav-link active">No quality standards found.</a>
                </li>
            @endforelse
        </ul>
        <div class="tab-content">
            @forelse ($qualityStandards as $index => $qualityStandard)
                <div class="tab-pane fade {{ $index == 0 ? 'show active' : '' }}" id="content-{{ $index + 1 }}" role="tabpanel">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h2 class="card-title">{{ $qualityStandard->name }}</h2>
                        </div>
                        <div class="card-body">
    <table class="table">
        <tr>
            <th>Purpose/Scope</th>
            <td>{{ $qualityStandard->purpose_scope }}</td>
        </tr>
        <tr>
            <th>Quality Policy</th>
            <td>{{ $qualityStandard->quality_policy }}</td>
        </tr>
        <tr>
            <th>Quality Objectives</th>
            <td>{{ $qualityStandard->quality_objectives }}</td>
        </tr>
        <tr>
            <th>Documentation Procedures</th>
            <td>{{ $qualityStandard->documentation_procedures }}</td>
        </tr>
        <tr>
            <th>Quality Control Measures</th>
            <td>{{ $qualityStandard->quality_control_measures }}</td>
        </tr>
        <tr>
            <th>Training Competence</th>
            <td>{{ $qualityStandard->training_competence }}</td>
        </tr>
        <tr>
            <th>Monitoring Measurement</th>
            <td>{{ $qualityStandard->monitoring_measurement }}</td>
        </tr>
        <tr>
            <th>Non-Conformance Management</th>
            <td>{{ $qualityStandard->non_conformance_management }}</td>
        </tr>
        <tr>
            <th>Continuous Improvement</th>
            <td>{{ $qualityStandard->continuous_improvement }}</td>
        </tr>
        <tr>
            <th>Compliance Regulations</th>
            <td>{{ $qualityStandard->compliance_regulations }}</td>
        </tr>
        <tr>
            <th>Supplier Management</th>
            <td>{{ $qualityStandard->supplier_management }}</td>
        </tr>
        <tr>
            <th>Customer Satisfaction</th>
            <td>{{ $qualityStandard->customer_satisfaction }}</td>
        </tr>
    </table>
</div>
                    </div>
                </div>
            @empty
                <div class="tab-pane fade show active">
                    <p>No quality standards found.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#qualityTabs a').click(function(e) {
            e.preventDefault();
            $(this).tab('show');
        });
    });
</script>
@endpush
