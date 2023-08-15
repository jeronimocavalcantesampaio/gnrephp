<?php

/*
 * Este arquivo é parte do programa GNRE PHP
 * GNRE PHP é um software livre; você pode redistribuí-lo e/ou 
 * modificá-lo dentro dos termos da Licença Pública Geral GNU como 
 * publicada pela Fundação do Software Livre (FSF); na versão 2 da 
 * Licença, ou (na sua opinião) qualquer versão.
 * Este programa é distribuído na esperança de que possa ser  útil, 
 * mas SEM NENHUMA GARANTIA; sem uma garantia implícita de ADEQUAÇÃO a qualquer
 * MERCADO ou APLICAÇÃO EM PARTICULAR. Veja a
 * Licença Pública Geral GNU para maiores detalhes.
 * Você deve ter recebido uma cópia da Licença Pública Geral GNU
 * junto com este programa, se não, escreva para a Fundação do Software
 * Livre(FSF) Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

namespace Gnre\Sefaz;

use Gnre\Configuration\Setup;
use Gnre\Webservice\Connection;
use Gnre\Sefaz\ObjetoSefaz;

/**
 * Classe que realiza o intermediário entre a transformação dos dados(objetos) e a conexão 
 * com o webservice da sefaz. Para isso é utilizado o objeto onde foi definido as configurações
 * e alguma classe que implementa a interface ObjectoSefaz (Gnre\Sefaz\ObjetoSefaz)
 * @package     gnre
 * @subpackage  sefaz
 * @author      Matheus Marabesi <matheus.marabesi@gmail.com>
 * @license     http://www.gnu.org/licenses/gpl-howto.html GPL
 * @version     1.0.0
 */
class Send {

    /**
     * As configuraçoes definidas pelo usuarios que sera utilizada para a 
     * transmissao dos dados
     * @var \Gnre\Configuration\Interfaces\Setup 
     */
    private $setup;

    /**
     * Armazena as configurações padrões em um atributo interno da classe para ser utilizado 
     * posteriormente pela classe
     * @param  \Gnre\Configuration\Interfaces\Setup $setup Configuraçoes definidas pelo usuário
     * @since  1.0.0
     */
    public function __construct(Setup $setup) {
        $this->setup = $setup;
    }

    /**
     * Obtém os dados necessários e realiza a conexão com o webservice da sefaz
     * @param  $objetoSefaz  Uma classe que implemente a interface ObjectoSefaz 
     * @return string|boolean  Caso a conexão seja feita com sucesso retorna uma string com um xml válido caso contrário retorna false
     * @since  1.0.0
     */
    public function sefaz(ObjetoSefaz $objetoSefaz) {
        $data = $objetoSefaz->toXml();
        $connection = new Connection($this->setup, $objetoSefaz->getHeaderSoap(), $data);
        return $connection->doRequest($objetoSefaz->soapAction());
    }

}
