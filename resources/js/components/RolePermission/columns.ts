import type { ColumnDef } from '@tanstack/vue-table'
import { h } from 'vue'
import DropdownAction from '@/components/Assets/data-table-dropdown.vue'
import { Checkbox } from '@/components/ui/checkbox'

export interface Users {
  id: number
  name: string
  description: string
  permissions: Array<string>
}

export const columns: ColumnDef<Users>[] = [
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
    header: 'Role Name',
    cell: ({ row }) => h('div', row.getValue('name')),
  },
  {
    accessorKey: 'description',
    header: 'Description',
    cell: ({ row }) => h('div', row.getValue('description')),
  },
  {
    accessorKey: 'permissions',
    header: 'Permissions',
    cell: ({ row }) => {
        const val = row.getValue('permissions')
        const text = Array.isArray(val) ? val.join(', ') : String(val ?? '')
        return h('div', text)
    },
  },
  
    
  {
    id: 'actions',
    header: 'Actions',
    enableHiding: false,
    cell: ({ row }) => {
        const role = row.original

        return h('div', { class: 'relative' }, h(DropdownAction, {
        role,
        // You might want to pass other relevant props
        onEdit: () => handleEdit(role.id),
        onDelete: () => handleDelete(role.id),
        }))
    },
  
  },

  
]