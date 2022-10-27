<x-app-layout>
    <x-slot name="title">{{ __('Create Invoice') }}</x-slot>
    <x-slot name="header_content">
        <div class="section-header-back">
            <a href="{{ url()->previous() }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>{{ __('Add Invoice') }}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item active"><a href="{{ route('backlog.index') }}">Invoice</a></div>
            <div class="breadcrumb-item">Create</div>
        </div>
    </x-slot>

    <h2 class="section-title">Create New </h2>
    <p class="section-lead mb-3">
        On this page you can create a new invoice data.
    </p>

    <div class="row">
        <div class="col-12">

            <form action="#" method="post">
                @csrf

                <div class="invoice">
                    <div class="invoice-print">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="invoice-title">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="title-invoice">Invoice</div>
                                            <p class="text-muted">#INV-12345</p>
                                        </div>
                                        <div class="col-6 text-right">
                                            <p style="font-size: 2rem" class="text-muted invoice-status">DRAFT</p>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <address>
                                            <h1 class="text-muted mb-2">FROM</h1>
                                            <p><strong>Test Company</strong></p>
                                            <p>Test</p>
                                        </address>
                                    </div>
                                    <div class="col-md-6">
                                        <address>
                                            <h1 class="text-muted mb-2">TO</h1>
                                            <p><strong>ABC Company</strong></p>
                                            <p>Test</p>
                                        </address>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <address>
                                            <h1 class="text-muted mb-2">ISSUED DATE</h1>
                                            <p><strong>Sep 22, 2022</strong></p>
                                        </address>
                                    </div>
                                    <div class="col-md-6">
                                        <address>
                                            <h1 class="text-muted mb-2">DUE DATE</h1>
                                            <p><strong>Sep 22, 2022</strong></p>
                                        </address>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <hr>
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover table-md">
                                        <tr>
                                            <th data-width="40">#</th>
                                            <th>Description</th>
                                            <th class="text-center">Price/Unit</th>
                                            <th class="text-center">Qty</th>
                                            <th class="text-right">Totals</th>
                                        </tr>
                                        <tr>
                                            <td>1</td>
                                            <td>Mouse Wireless</td>
                                            <td class="text-center">$10.99</td>
                                            <td class="text-center">1</td>
                                            <td class="text-right">$10.99</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>Keyboard Wireless</td>
                                            <td class="text-center">$20.00</td>
                                            <td class="text-center">3</td>
                                            <td class="text-right">$60.00</td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>Headphone Blitz TDR-3000</td>
                                            <td class="text-center">$600.00</td>
                                            <td class="text-center">1</td>
                                            <td class="text-right">$600.00</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-lg-12 text-right">
                                        <hr class="mt-2 mb-2">
                                        <div class="invoice-detail-item">
                                            <div class="invoice-detail-name">Total</div>
                                            <div class="invoice-detail-value invoice-detail-value-lg">$685.99</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="text-md-right">
                        <button type="submit" class="btn btn-primary btn-icon icon-left"><i class="fas fa-file-alt"></i>
                            Create Invoice</button>
                    </div>
                </div>

            </form>

        </div>
    </div>

</x-app-layout>