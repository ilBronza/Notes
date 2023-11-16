<?php

namespace IlBronza\Notes\Http\Controllers;

use App\Http\Controllers\Controller;
use IlBronza\Notes\Notes;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 * Example of extended controller
 * 
 * 
 * <?php
 * 
 * namespace App\Http\Controllers\Orders;
 * 
 * use App\Models\ProductsPackage\Order;
 * use IlBronza\Notes\Http\Controllers\AbstractPopupNoteController;
 * 
 * class OrderNotesController extends AbstractPopupNoteController
 * {
 *     public function getPopupByModel(Order $order)
 *     {
 *         return $this->_getPopupByModel(
 *             $order
 *         );
 *     }
 * }
 * 
 * 
 **/

abstract class AbstractPopupNoteController extends Controller
{
    public function _getPopupByModel(Model $model)
    {
        $related = $model->getNoteRelatedElements();

        $notes = Notes::getAllNotesWithRelated($model, $related);

        return view('notes::_popup', compact('notes'));        
    }
}