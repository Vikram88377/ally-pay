<div class="bg-dark text-white p-3"
     style="width:250px; min-height:100vh;">

    <h4>Ally Pay Merchant</h4>

    <ul class="nav flex-column mt-4">
        <li class="nav-item">
            <a class="nav-link text-white"
               href="{{ route('merchant.dashboard') }}">
                Dashboard
            </a>
        </li>

      <li class="nav-item">
    <a class="nav-link text-white"
       href="{{ route('merchant.payments.index') }}">
        Payments
    </a>
</li>

        <li class="nav-item">
         <a class="nav-link text-white"
   href="{{ route('merchant.api-keys.index') }}">
    API Keys
</a>
        </li>

        <li class="nav-item">
<a class="nav-link text-white"
   href="{{ route('merchant.webhook-settings.index') }}">
    Webhooks
</a>
        </li>
    </ul>
</div>