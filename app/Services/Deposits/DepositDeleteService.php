<?php

namespace App\Services\Deposits;

use _PHPStan_5930232b5\Nette\Neon\Exception;
use App\Base\Abstract\BaseVar;
use App\Models\Deposit;
use App\Models\Type;
use App\Services\Operations\OperationCreateService;
use Illuminate\Support\Facades\Auth;

class DepositDeleteService
{
    public static function handle(Deposit $deposit) : bool
    {
        if($deposit->delete())
        {
            if ($deposit->amount > BaseVar::SIGMA)
            {
                $fields = [
                    'category' => Deposit::FROM_DEPOSIT,
                    'type'     => Type::DEPOSIT,
                    'amount'   => $deposit->amount,
                    'comment'  => 'Закрытие депозита "' . $deposit->name ,
                    'userId'   => Auth::user()->id,
                ];

                 OperationCreateService::handle($fields);
            }

            return true;
        }
        else
        {
            throw new Exception('The deposit has not been deleted');
        }
    }
}
