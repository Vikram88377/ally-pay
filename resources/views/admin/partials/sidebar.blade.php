<div class="bg-dark text-white p-3" style="width:250px; min-height:100vh;">
    <h4>Ally Pay</h4>

    <ul class="nav flex-column mt-4">
        <li class="nav-item">
            <a class="nav-link text-white" href="{{ route('admin.dashboard') }}">Dashboard</a>
        </li>

        <li class="nav-item">
              <a class="nav-link text-white" href="{{ route('admin.users.index') }}">Users</a>
        </li>

        <li class="nav-item">
          <a class="nav-link text-white" href="{{ route('admin.merchants.index') }}">Merchants</a>
        </li>

        <li class="nav-item">
           <a class="nav-link text-white" href="{{ route('admin.payments.index') }}">
    Payments
</a>
        </li>

                        <li class="nav-item">
          <a class="nav-link text-white" href="{{ route('admin.wallets.index') }}">Wallets</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white" href="{{ route('admin.webhooks.index') }}">
    Webhooks
</a>
        </li>

            <li class="nav-item"><a class="nav-link text-white" href="{{ route('admin.audit-logs.index') }}">
        Audit Logs
    </a>
</li>

                    <li class="nav-item mt-3">
                        <span class="text-secondary">
                            Reports
                        </span>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-white"
                        href="{{ route('admin.reports.payments') }}">
                            Payment Report
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-white"
                        href="{{ route('admin.reports.transactions') }}">
                            Wallet Report
                        </a>
                    </li>

    </ul>

 
</div>