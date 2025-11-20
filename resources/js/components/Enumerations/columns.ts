import type { ColumnDef } from '@tanstack/vue-table'
import { h } from 'vue'
import DropdownAction from '@/components/Assets/data-table-dropdown.vue'
import { Checkbox } from '@/components/ui/checkbox'

export interface Assets {
  id: number
  name: string
  description: string
  assetConditions: string
}

export const columns: ColumnDef<Assets>[] = [
   {
        id: 'select',
        header: ({ table }) => h(Checkbox, {
            'modelValue': table.getIsAllPageRowsSelected(),
            'onUpdate:modelValue': (value: boolean) => table.toggleAllPageRowsSelected(!!value),
            'ariaLabel': 'Select all',
        }),
        cell: ({ row }) => h(Checkbox, {
            'modelValue': row.getIsSelected(),
            'onUpdate:modelValue': (value: boolean) => row.toggleSelected(!!value),
            'ariaLabel': 'Select row',
        }),
        enableSorting: false,
        enableHiding: false,
    },
    {
    accessorKey: 'name',
    header: 'Name',
    cell: ({ row }) => h('div', row.getValue('name')),
  },
  {
    accessorKey: 'description',
    header: 'Description',
    cell: ({ row }) => h('div', row.getValue('description')),
  },
  {
    accessorKey: 'assetConditions',
    header: 'Conditions',
    cell: ({ row }) => h('div', row.getValue('assetConditions')),
  },
  {
    id: 'actions',
    header: 'Actions',
    enableHiding: false,
    cell: ({ row }) => {
        const asset = row.original

        return h('div', { class: 'relative' }, h(DropdownAction, {
        asset,
        // You might want to pass other relevant props
        onEdit: () => handleEdit(asset.id),
        onDelete: () => handleDelete(asset.id),
        }))
    },
  
  },

  
]