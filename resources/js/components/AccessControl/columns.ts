import type { ColumnDef } from '@tanstack/vue-table'
import { h } from 'vue'
import DropdownAction from '@/components/Assets/data-table-dropdown.vue'
import { Checkbox } from '@/components/ui/checkbox'

export interface Users {
  id: number
  name: string
  email: string
  role: string
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
    header: 'Name',
    cell: ({ row }) => h('div', row.getValue('name')),
  },
  {
    accessorKey: 'email',
    header: 'Email',
    cell: ({ row }) => h('div', row.getValue('email')),
  },
  {
    accessorKey: 'role',
    header: 'Role',
  },
    
  {
    id: 'actions',
    header: 'Actions',
    enableHiding: false,
    cell: ({ row }) => {
        const user = row.original

        return h('div', { class: 'relative' }, h(DropdownAction, {
        user,
        // You might want to pass other relevant props
        onEdit: () => handleEdit(user.id),
        onDelete: () => handleDelete(user.id),
        }))
    },
  
  },

  
]