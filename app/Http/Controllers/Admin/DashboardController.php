return view('admin.dashboard', [
    'clients' => Client::count(),
    'beneficiaries' => Beneficiary::count(),
]);
