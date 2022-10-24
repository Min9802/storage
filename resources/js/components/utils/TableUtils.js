import React, { useMemo, useState } from "react";
class TableUtils {
    static useSortableData = (items, config = null) => {
        const [sortConfig, setSortConfig] = useState(config);

        const sortedItems = useMemo(() => {
            if (items) {
                let sortableItems = [...items];
                if (sortConfig !== null) {
                    sortableItems.sort((a, b) => {
                        if (a[sortConfig.key] < b[sortConfig.key]) {
                            return sortConfig.direction === "asc" ? -1 : 1;
                        }
                        if (a[sortConfig.key] > b[sortConfig.key]) {
                            return sortConfig.direction === "asc" ? 1 : -1;
                        }
                        return 0;
                    });
                }
                return sortableItems;
            }
        }, [items, sortConfig]);

        const requestSort = (key) => {
            let direction = "asc";
            if (
                sortConfig &&
                sortConfig.key === key &&
                sortConfig.direction === "asc"
            ) {
                direction = "desc";
            }
            setSortConfig({ key, direction });
        };

        return { items: sortedItems, requestSort, sortConfig };
    };
}
export default TableUtils;
