use App\Http\Controllers\MonitorController;

Route::get('/monitor-data', [MonitorController::class, 'getData'])->name('api.monitor.data');