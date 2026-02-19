namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Loan extends Model {
    protected $fillable = ['book_id', 'applicant_name', 'loan_date', 'return_date'];

    public function book(): BelongsTo {
        return $this->belongsTo(Book::class);
    }
}