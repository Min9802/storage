import React, { useState, useEffect } from "react";
import Skeleton, { SkeletonTheme } from "react-loading-skeleton";
/**
 * Skeleton table row
 * @param {var} row - set row table skeleton
 * @returns
 */
const TableSkeleton = ({row}) => {
    return (
        <tr>
            {[...Array(row)].map((e,i) => (
                <td key={i}>
                    <Skeleton />
                </td>
            ))}
        </tr>
    );
};

export default TableSkeleton;
