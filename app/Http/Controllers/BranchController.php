<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function index()
    {
        $branches = Branch::withCount('users')->orderBy('name')->get();
        return view('branches.index', compact('branches'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'      => ['required', 'string', 'max:255'],
            'code'      => ['required', 'string', 'max:50', 'unique:branches,code'],
            'address'   => ['nullable', 'string', 'max:500'],
            'phone'     => ['nullable', 'string', 'max:50'],
        ]);

        $validated['is_active'] = $request->has('is_active');

        Branch::create($validated);

        return redirect()->route('branches.index')->with('success', 'Cabang berhasil ditambahkan.');
    }

    public function update(Request $request, Branch $branch)
    {
        $validated = $request->validate([
            'name'      => ['required', 'string', 'max:255'],
            'code'      => ['required', 'string', 'max:50', 'unique:branches,code,' . $branch->id],
            'address'   => ['nullable', 'string', 'max:500'],
            'phone'     => ['nullable', 'string', 'max:50'],
        ]);

        $validated['is_active'] = $request->has('is_active');

        $branch->update($validated);

        return redirect()->route('branches.index')->with('success', 'Data cabang berhasil diperbarui.');
    }

    public function destroy(Branch $branch)
    {
        // Check if branch has users or products or orders
        if ($branch->users()->count() > 0 || $branch->products()->count() > 0 || $branch->orders()->count() > 0) {
            return redirect()->route('branches.index')->with('error', 'Cabang tidak dapat dihapus karena masih memiliki relasi data (Pengguna/Produk/Transaksi). Nonaktifkan cabang sebagai gantinya.');
        }

        $branch->delete();

        return redirect()->route('branches.index')->with('success', 'Cabang berhasil dihapus.');
    }
}
