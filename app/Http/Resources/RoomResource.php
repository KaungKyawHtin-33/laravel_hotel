<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RoomResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'        => $this->id,
            'name'      => $this->name,
            'type'      => $this->type,
            'occupancy' => $this->occupancy,
            'price'     => $this->price_per_day,
            // 'bed_id'    => $this->bed_id,
            // 'bed_name'  => $this->when(
            //         $this->getBed() != null,
            //             $this->getBed->name
            // ),
            'bed'       => $this->when(
                $this->getBed() != null,
                BedResource::make($this->getBed)
            ),
            'thumbnail' => $this->thumbnail,
            'view_name' => $this->when(
                    $this->getView() != null,
                       $this->getView->name
            ),
            'gallery'   => $this->when(
                $this->getRoomGalleriesByRoom() != null,
                $this->getRoomGalleriesByRoom
            ),
        ];
    }
}
