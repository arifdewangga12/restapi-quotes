<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Http\Resources\QuoteResource;
use App\User;
use App\Quote;

class QuoteController extends Controller
{
  public function index()
  {
    $quotes = Quote::latest()->get();

    return QuoteResource::collection($quotes);

  }
   public function show(Quote $quote)
   {
      return new QuoteResource($quote);
   }

   public function update(Request $request,Quote $quote)
   {

       $quote->update([
         'message' => $request->message,
       ]);
       return new QuoteResource($quote);
   }
    public function store(Request $request)
    {
        $this->validate($request,[
            'message' => 'required',
          ]);

        $quote = Quote::create([
            'user_id' => auth()->id(),
            'message' => $request->message,
         ]);
         return new QuoteResource($quote);
    }
}
