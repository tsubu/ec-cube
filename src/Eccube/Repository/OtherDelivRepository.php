<?php
/*
 * This file is part of EC-CUBE
 *
 * Copyright(c) 2000-2015 LOCKON CO.,LTD. All Rights Reserved.
 *
 * http://www.lockon.co.jp/
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */


namespace Eccube\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * OtherDelivRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class OtherDelivRepository extends EntityRepository
{
    /**
     * @param  \Eccube\Entity\Customer   $Customer
     * @param  integer|null              $id
     * @return \Eccube\Entity\OtherDeliv
     * @throws Exception
     */
    public function findOrCreateByCustomerAndId(\Eccube\Entity\Customer $Customer, $id = null)
    {
        if (!$id) {
            $OtherDeliv = new \Eccube\Entity\OtherDeliv();
            $OtherDeliv->setCustomer($Customer);
        } else {
            $qb = $this->createQueryBuilder('od')
                ->andWhere('od.Customer = :Customer AND od.id = :id')
                ->setParameters(array(
                    'Customer' => $Customer,
                    'id' => $id,
                ));

            $OtherDeliv = $qb
                ->getQuery()
                ->getSingleResult();
        }

        return $OtherDeliv;
    }

    /**
     * @param  \Eccube\Entity\Customer $Customer
     * @param  integer                 $id
     * @return bool
     */
    public function deleteByCustomerAndId(\Eccube\Entity\Customer $Customer, $id)
    {
        $qb = $this->createQueryBuilder('od')
            ->andWhere('od.Customer = :Customer AND od.id = :id')
            ->setParameters(array(
                'Customer' => $Customer,
                'id' => $id,
            ));

        try {
            $OtherDeliv = $qb
                ->getQuery()
                ->getSingleResult();
        } catch (\Exception $e) {
            return false;
        }

        $em = $this->getEntityManager();
        $em->remove($OtherDeliv);
        $em->flush();

        return true;
    }
}
