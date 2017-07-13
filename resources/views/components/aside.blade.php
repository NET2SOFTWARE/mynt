<aside id="accordion" class="col-sm-3 col-md-2 hidden-xs-down medium sidebar">
    <section class="card according-con">
        <a class="according-item" data-toggle="collapse" data-parent="#accordion" href="#collapseTransaction" aria-expanded="true" aria-controls="collapseTransaction">
            Transaction
        </a>
        <section id="collapseTransaction" class="collapse {{ Request::segment(1) == 'transaction' ? 'show' : '' }}" aria-labelledby="collapseTransaction">
            <nav class="nav flex-column">
                <a class="nav-link according-sub-item {{ Request::url() == route('transaction.index') ? 'active' : '' }}" href="{{ route('transaction.index') }}">All Transaction</a>
                <a class="nav-link according-sub-item {{ Request::url() == route('transaction.success.index') ? 'active' : '' }}" href="{{ route('transaction.success.index') }}">Success Transaction</a>
                <a class="nav-link according-sub-item {{ Request::url() == route('transaction.failed.index') ? 'active' : '' }}" href="{{ route('transaction.failed.index') }}">Failed Transaction</a>
                <a class="nav-link according-sub-item" href="{{ route('construction') }}">Transaction Reversal</a>
            </nav>
        </section>
    </section>
    <section class="card according-con">
        <a class="collapsed according-item" data-toggle="collapse" data-parent="#accordion" href="#collapseCompany" aria-expanded="false" aria-controls="collapseCompany">
            Company
        </a>
        <section id="collapseCompany" class="collapse {{ Request::segment(1) == 'company' ? 'show' : '' }}" aria-labelledby="collapseCompany">
            <nav class="nav flex-column">
                <a class="nav-link according-sub-item {{ Request::url() == route('company.index', ['all']) ? 'active' : '' }}" href="{{ route('company.index', ['all']) }}">All Company</a>
                <a class="nav-link according-sub-item {{ Request::url() == route('company.index', ['document']) ? 'active' : '' }}" href="{{ route('company.index', ['document']) }}">Company Document</a>
                <a class="nav-link according-sub-item {{ Request::url() == route('company.index', ['deactivate']) ? 'active' : '' }}" href="{{ route('company.index', ['deactivate']) }}">Deactivate Account</a>
                <a class="nav-link according-sub-item {{ Request::url() == route('company.index', ['transactions']) ? 'active' : '' }}" href="{{ route('company.index', ['transactions']) }}">Company Transaction</a>
            </nav>
        </section>
    </section>
    <section class="card according-con">
        <a class="collapsed according-item" data-toggle="collapse" data-parent="#accordion" href="#collapseMerchant" aria-expanded="false" aria-controls="collapseMerchant">
            Merchant
        </a>
        <section id="collapseMerchant" class="collapse {{ Request::segment(1) == 'merchant' ? 'show' : '' }}" aria-labelledby="collapseMerchant">
            <nav class="nav flex-column">
                <a class="nav-link according-sub-item {{ Request::url() == route('merchant.index') ? 'active' : '' }}" href="{{ route('merchant.index') }}">All Merchant</a>
                <a class="nav-link according-sub-item {{ Request::url() == route('merchant.deactivate.index') ? 'active' : '' }}" href="{{ route('merchant.deactivate.index') }}">Deactivate Merchant</a>
                <a class="nav-link according-sub-item {{ Request::url() == route('merchant.transactions.index') ? 'active' : '' }}" href="{{ route('merchant.transactions.index') }}">Merchant Transactions</a>
                <a class="nav-link according-sub-item {{ Request::url() == route('merchant.index', ['shared-api']) ? 'active' : '' }}" href="{{ route('construction') }}">Shared API Configuration</a>
            </nav>
        </section>
    </section>
    <section class="card according-con">
        <a class="collapsed according-item" data-toggle="collapse" data-parent="#accordion" href="#collapseMember" aria-expanded="false" aria-controls="collapseMember">
            Member
        </a>
        <section id="collapseMember" class="collapse {{ Request::segment(1) == 'member' ? 'show' : '' }}" aria-labelledby="collapseMember">
            <nav class="nav flex-column">
                <a class="nav-link according-sub-item {{ Request::url() == route('member.index') ? 'active' : '' }}" href="{{ route('member.index') }}">All Member</a>
                <a class="nav-link according-sub-item {{ Request::url() == route('member.approval') ? 'active' : '' }}" href="{{ route('member.approval') }}">Registration Approval</a>
                <a class="nav-link according-sub-item {{ Request::url() == route('member.pending_upgrade') ? 'active' : '' }}" href="{{ route('member.pending_upgrade') }}">Pending Upgrade</a>
                <a class="nav-link according-sub-item {{ Request::url() == route('member.child_account') ? 'active' : '' }}" href="{{ route('member.child_account') }}">Child Account</a>
                <a class="nav-link according-sub-item {{ Request::url() == route('member.document') ? 'active' : '' }}" href="{{ route('member.document') }}">Member Document</a>
                <a class="nav-link according-sub-item {{ Request::url() == route('member.deactivate') ? 'active' : '' }}" href="{{ route('member.deactivate') }}">Deactivate Account</a>
                <a class="nav-link according-sub-item {{ Request::url() == route('member.transactions') ? 'active' : '' }}" href="{{ route('member.transactions') }}">Member Transactions</a>
            </nav>
        </section>
    </section>
    <section class="card according-con">
        <a class="collapsed according-item" data-toggle="collapse" data-parent="#accordion" href="#collapseService" aria-expanded="false" aria-controls="collapseService">
            Service
        </a>
        <section id="collapseService" class="collapse {{ in_array(Request::segment(1), ['service','charge','mapping_charge']) ? 'show' : '' }}" aria-labelledby="collapseService">
            <nav class="nav flex-column">
                <a class="nav-link according-sub-item {{ Request::url() == route('service.index') ? 'active' : '' }}" href="{{ route('service.index') }}">All</a>
                <a class="nav-link according-sub-item {{ Request::url() == route('charge.index') ? 'active' : '' }}" href="{{ route('charge.index') }}">Mastering Charge</a>
                <a class="nav-link according-sub-item {{ Request::url() == route('mapping_charge.index') ? 'active' : '' }}" href="{{ route('mapping_charge.index') }}">Mapping Charge</a>
                <a class="nav-link according-sub-item {{ Request::url() == route('mapping_fee.all') ? 'active' : '' }}" href="{{ route('mapping_fee.all') }}">Mapping Fee</a>
                <a class="nav-link according-sub-item {{ Request::url() == route('service.deactivate.index') ? 'active' : '' }}" href="{{ route('service.deactivate.index') }}">Deactivate Services</a>
            </nav>
        </section>
    </section>
    <section class="card according-con">
        <a class="collapsed according-item" data-toggle="collapse" data-parent="#accordion" href="#collapseProduct" aria-expanded="false" aria-controls="collapseProduct">
            Product
        </a>
        <section id="collapseProduct" class="collapse {{ in_array(Request::segment(1), ['product','mapping_product']) ? 'show' : '' }}" aria-labelledby="collapseProduct">
            <nav class="nav flex-column">
                <a class="nav-link according-sub-item {{ Request::url() == route('product.index') ? 'active' : '' }}" href="{{ route('product.index') }}">All</a>
                <a class="nav-link according-sub-item {{ Request::url() == route('product.purchase.index') ? 'active' : '' }}" href="{{ route('product.purchase.index') }}">Setting Purchase Price</a>
                <a class="nav-link according-sub-item {{ Request::url() == route('product.sales.index') ? 'active' : '' }}" href="{{ route('product.sales.index') }}">Setting Sales Price</a>
                <a class="nav-link according-sub-item {{ Request::url() == route('product.charge.index') ? 'active' : '' }}" href="{{ route('product.charge.index') }}">Setting Charge</a>
                <a class="nav-link according-sub-item {{ Request::url() == route('product.fee.all') ? 'active' : '' }}" href="{{ route('product.fee.all') }}">Mapping Fee</a>
                <a class="nav-link according-sub-item {{ Request::url() == route('product.deactivate.index') ? 'active' : '' }}" href="{{ route('product.deactivate.index') }}">Deactivate Product</a>
            </nav>
        </section>
    </section>
    <section class="card according-con">
        <a class="collapsed according-item" data-toggle="collapse" data-parent="#accordion" href="#collapseAdministrator" aria-expanded="false" aria-controls="collapseAdministrator">
            Administrator
        </a>
        <section id="collapseAdministrator"
                 class="collapse {{
                 (Request::segment(1) == 'administrator' or Request::segment(1) == 'role') ? 'show' : '' }}" aria-labelledby="collapseAdministrator">
            <nav class="nav flex-column">
                <a class="nav-link according-sub-item {{ Request::url() == route('administrator.index', ['all']) ? 'active' : '' }}" href="{{ route('administrator.index', ['all']) }}">All</a>
                {{-- <a class="nav-link according-sub-item" href="{{ route('construction') }}">Super Admin</a> --}}
                <a class="nav-link according-sub-item {{ (Request::url() == route('role.index') or Request::url() == route('role.create')) ? 'active' : '' }}" href="{{ route('role.index') }}">Setting Role</a>
                <a class="nav-link according-sub-item {{ Request::url() == route('administrator.deactivate.index') ? 'active' : '' }}" href="{{ route('administrator.deactivate.index') }}">Deactivate Access</a>
            </nav>
        </section>
    </section>
    <section class="card according-con">
        <a class="collapsed according-item" data-toggle="collapse" data-parent="#accordion" href="#collapseTerminal" aria-expanded="false" aria-controls="collapseTerminal">
            Terminal
        </a>
        <section id="collapseTerminal" class="collapse {{ Request::segment(1) == 'terminal' ? 'show' : '' }}" aria-labelledby="collapseTerminal">
            <nav class="nav flex-column">
                <a class="nav-link according-sub-item {{ Request::url() == route('terminal.index') ? 'active' : '' }}" href="{{ route('terminal.index') }}">All Terminal</a>
                <a class="nav-link according-sub-item {{ Request::url() == route('terminal.deactivate.index') ? 'active' : '' }}" href="{{ route('terminal.deactivate.index') }}">Deactivate Terminal</a>
            </nav>
        </section>
    </section>
    <section class="card according-con">
        <a class="collapsed according-item" data-toggle="collapse" data-parent="#accordion" href="#collapseSystemManagement" aria-expanded="false" aria-controls="collapseSystemManagement">
            System Management
        </a>
        <section id="collapseSystemManagement"
                 class="collapse{{(
                 Request::url() == route('industry.index') or
                 Request::url() == route('identity.index') or
                 Request::url() == route('partnership.index') or
                 Request::url() == route('country.index') or
                 Request::url() == route('state.index') or
                 Request::url() == route('city.index')
                 ) ? ' show' : '' }}"
                 aria-labelledby="collapseSystemManagement">
            <nav class="nav flex-column">
                <a class="nav-link according-sub-item {{ Request::url() == route('industry.index') ? 'active' : '' }}" href="{{ route('industry.index') }}">Institution</a>
                <a class="nav-link according-sub-item {{ Request::url() == route('identity.index') ? 'active' : '' }}" href="{{ route('identity.index') }}">Identity</a>
                <a class="nav-link according-sub-item {{ Request::url() == route('partnership.index') ? 'active' : '' }}" href="{{ route('partnership.index') }}">Partnership</a>
                <a class="nav-link according-sub-item {{ Request::url() == route('country.index') ? 'active' : '' }}" href="{{ route('country.index') }}">Country</a>
                <a class="nav-link according-sub-item {{ Request::url() == route('state.index') ? 'active' : '' }}" href="{{ route('state.index') }}">State</a>
                <a class="nav-link according-sub-item {{ Request::url() == route('city.index') ? 'active' : '' }}" href="{{ route('city.index') }}">City</a>
            </nav>
        </section>
    </section>
    {{-- <section class="card according-con">
        <a class="collapsed according-item" data-toggle="collapse" data-parent="#accordion" href="#collapseEmailManagement" aria-expanded="false" aria-controls="collapseEmailManagement">
            E-mail Management
        </a>
        <section id="collapseEmailManagement" class="collapse" aria-labelledby="collapseEmailManagement">
            <nav class="nav flex-column">
                <a class="nav-link according-sub-item" href="{{ route('construction') }}">Re-emailing Confirmation</a>
                <a class="nav-link according-sub-item" href="{{ route('construction') }}">Re-emailing Upgrade</a>
            </nav>
        </section>
    </section> --}}
    {{-- <section class="card according-con">
        <a class="collapsed according-item" data-toggle="collapse" data-parent="#accordion" href="#collapseAccountManagement" aria-expanded="false" aria-controls="collapseAccountManagement">
            Account Management
        </a>
        <section id="collapseAccountManagement" class="collapse" aria-labelledby="collapseAccountManagement">
            <nav class="nav flex-column">
                <a class="nav-link according-sub-item" href="{{ route('construction') }}">Grouping Account</a>
                <a class="nav-link according-sub-item" href="{{ route('construction') }}">Limit Access Transaction</a>
                <a class="nav-link according-sub-item" href="{{ route('construction') }}">Deactivate Account</a>
            </nav>
        </section>
    </section> --}}
    <section class="card according-con">
        <a class="collapsed according-item" data-toggle="collapse" data-parent="#accordion" href="#collapseReportManagement" aria-expanded="false" aria-controls="collapseReportManagement">
            Report Management
        </a>
        <section id="collapseReportManagement" class="collapse {{ Request::segment(1) == 'report' ? 'show' : '' }}" aria-labelledby="collapseReportManagement">
            <nav class="nav flex-column">
                <a class="nav-link according-sub-item {{ Request::url() == route('general.ledger.index') ? 'active' : '' }}" href="{{ route('general.ledger.index') }}">General Ledger</a>
                <a class="nav-link according-sub-item {{ Request::url() == route('report.company.index') ? 'active' : '' }}" href="{{ route('report.company.index') }}">Report Company</a>
                <a class="nav-link according-sub-item {{ Request::url() == route('report.merchant.index') ? 'active' : '' }}" href="{{ route('report.merchant.index') }}">Report Merchant</a>
                <a class="nav-link according-sub-item {{ Request::url() == route('report.account.index') ? 'active' : '' }}" href="{{ route('report.account.index') }}">Report Account</a>
                <a class="nav-link according-sub-item {{ Request::url() == route('report.service.index') ? 'active' : '' }}" href="{{ route('report.service.index') }}">Report Service</a>
                <a class="nav-link according-sub-item {{ Request::url() == route('report.product.index') ? 'active' : '' }}" href="{{ route('report.product.index') }}">Report Product</a>
                <a class="nav-link according-sub-item {{ Request::url() == route('report.tracing.index') ? 'active' : '' }}" href="{{ route('report.tracing.index') }}">Transaction Tracing</a>
            </nav>
        </section>
    </section>
</aside>