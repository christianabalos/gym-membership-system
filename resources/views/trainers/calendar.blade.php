<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    
    <div>
        <button class="btn btn-secondary">Previous</button>
        <span style="margin: 0 15px; font-weight: bold;">July 2026</span>
        <button class="btn btn-secondary">Next</button>
    </div>

    <div class="d-print-none">
        <button onclick="window.print()" class="btn btn-primary">
            <i class="fa fa-print"></i> Print Schedule
        </button>
    </div>
</div>

<style>
    @media print {
        .btn, .d-print-none, .sidebar, .navbar, .header {
            display: none !important;
        }
    }
</style>