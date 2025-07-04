<?php
namespace Src\Models;

class Invoice extends BaseModel
{
    public function allByProject(int $projectId, int $userId): array
    {
        $sql = "SELECT inv.invoice_id, inv.stage_id, inv.amount, inv.description, inv.date_issued
                FROM invoices inv
                JOIN stages st ON inv.stage_id = st.stage_id
                JOIN projects p ON st.project_id = p.project_id
                WHERE p.project_id = :project_id
                  AND p.user_id    = :user_id
                ORDER BY inv.date_issued DESC";
        return $this->fetchAll($sql, [
            ':project_id' => $projectId,
            ':user_id'    => $userId
        ]);
    }

    public function findByUser(int $invoiceId, int $userId): ?array
    {
        $sql = "SELECT inv.invoice_id, inv.stage_id, inv.amount, inv.description, inv.date_issued
                FROM invoices inv
                JOIN stages st ON inv.stage_id = st.stage_id
                JOIN projects p ON st.project_id = p.project_id
                WHERE inv.invoice_id = :invoice_id
                  AND p.user_id      = :user_id";
        return $this->fetchOne($sql, [
            ':invoice_id' => $invoiceId,
            ':user_id'    => $userId
        ]);
    }

    public function create(array $data): bool
    {
        $sql = "INSERT INTO invoices
                (stage_id, amount, description, date_issued)
                VALUES
                (:stage_id, :amount, :description, :date_issued)";
        return $this->execute($sql, [
            ':stage_id'    => $data['stage_id'],
            ':amount'      => $data['amount'],
            ':description' => $data['description'],
            ':date_issued' => $data['date_issued'],
        ]);
    }

    public function update(int $invoiceId, array $data): bool
    {
        $sql = "UPDATE invoices
                SET stage_id    = :stage_id,
                    amount      = :amount,
                    description = :description,
                    date_issued = :date_issued
                WHERE invoice_id = :invoice_id";
        return $this->execute($sql, [
            ':stage_id'    => $data['stage_id'],
            ':amount'      => $data['amount'],
            ':description' => $data['description'],
            ':date_issued' => $data['date_issued'],
            ':invoice_id'  => $invoiceId
        ]);
    }
}