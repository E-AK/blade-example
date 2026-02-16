import { Table } from './Table';

export default function initTables() {
  $('.data-table').each((_, element) => {
    new Table(element);
  });
}
