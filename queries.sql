-- a)
select nome
from (select nif, categoria
      from ((select ean, forn_primario as nif, categoria
             from produto)
            union
            (select nif, ean
             from fornece_sec
                natural join
                (select ean, categoria from produto))) as produto_fornecedores
      group by nif
      having count(categoria) >= all(select count(categoria)
                                     from ((select ean, forn_primario as nif, categoria
                                            from produto)
                                           union
                                           (select nif, ean
                                            from fornece_sec
                                               natural join
                                               (select ean, categoria from produto))) as nifs_resposta))
      natural join fornecedor;

-- b)
select nif, nome
from (select forn_primario as nif, categoria
      from produto
      group by nif
      having count(distinct categoria) = (select count(nome)
                                          from categoria_simples)) as produtos
     natural join
     fornecedor;

-- c)
select ean
from produto
where ean not in (select ean
                  from reposicao);

-- d)
select ean
from fornece_sec
group by ean
having count(nif) > 10;

-- e)
select ean
from(select distinct ean, operador
     from reposicao) as ean_operador
group by ean
having count(operador) = 1;
